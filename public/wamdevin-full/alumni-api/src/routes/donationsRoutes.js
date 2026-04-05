const express = require('express');
const Donation = require('../models/Donation');
const { protect, authorize } = require('../middleware/auth');

const router = express.Router();

router.get('/', protect, async (req, res) => {
  try {
    const donations = await Donation.find()
      .populate('user', 'name email')
      .sort({ date: -1 });
    return res.json(donations);
  } catch (error) {
    return res.status(500).json({ message: 'Failed to fetch donations.', error: error.message });
  }
});

router.get('/:id', protect, async (req, res) => {
  try {
    const donation = await Donation.findById(req.params.id).populate('user', 'name email');
    if (!donation) return res.status(404).json({ message: 'Donation not found.' });
    return res.json(donation);
  } catch (error) {
    return res.status(500).json({ message: 'Failed to fetch donation.', error: error.message });
  }
});

router.post('/', protect, authorize('admin'), async (req, res) => {
  try {
    const payload = {
      ...req.body,
      user: req.body.user || req.user._id,
    };
    const donation = await Donation.create(payload);
    return res.status(201).json(donation);
  } catch (error) {
    return res.status(400).json({ message: 'Failed to create donation.', error: error.message });
  }
});

router.put('/:id', protect, authorize('admin'), async (req, res) => {
  try {
    const donation = await Donation.findByIdAndUpdate(req.params.id, req.body, {
      new: true,
      runValidators: true,
    });
    if (!donation) return res.status(404).json({ message: 'Donation not found.' });
    return res.json(donation);
  } catch (error) {
    return res.status(400).json({ message: 'Failed to update donation.', error: error.message });
  }
});

router.delete('/:id', protect, authorize('admin'), async (req, res) => {
  try {
    const donation = await Donation.findByIdAndDelete(req.params.id);
    if (!donation) return res.status(404).json({ message: 'Donation not found.' });
    return res.json({ message: 'Donation deleted successfully.' });
  } catch (error) {
    return res.status(500).json({ message: 'Failed to delete donation.', error: error.message });
  }
});

module.exports = router;
