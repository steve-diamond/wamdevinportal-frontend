const express = require('express');
const Job = require('../models/Job');
const { protect, authorize } = require('../middleware/auth');

const router = express.Router();

router.get('/', protect, async (req, res) => {
  try {
    const jobs = await Job.find().populate('postedBy', 'name email').sort({ createdAt: -1 });
    return res.json(jobs);
  } catch (error) {
    return res.status(500).json({ message: 'Failed to fetch jobs.', error: error.message });
  }
});

router.get('/:id', protect, async (req, res) => {
  try {
    const job = await Job.findById(req.params.id).populate('postedBy', 'name email');
    if (!job) return res.status(404).json({ message: 'Job not found.' });
    return res.json(job);
  } catch (error) {
    return res.status(500).json({ message: 'Failed to fetch job.', error: error.message });
  }
});

router.post('/', protect, authorize('admin'), async (req, res) => {
  try {
    const payload = {
      ...req.body,
      postedBy: req.user._id,
    };
    const job = await Job.create(payload);
    return res.status(201).json(job);
  } catch (error) {
    return res.status(400).json({ message: 'Failed to create job.', error: error.message });
  }
});

router.put('/:id', protect, authorize('admin'), async (req, res) => {
  try {
    const job = await Job.findByIdAndUpdate(req.params.id, req.body, {
      new: true,
      runValidators: true,
    });
    if (!job) return res.status(404).json({ message: 'Job not found.' });
    return res.json(job);
  } catch (error) {
    return res.status(400).json({ message: 'Failed to update job.', error: error.message });
  }
});

router.delete('/:id', protect, authorize('admin'), async (req, res) => {
  try {
    const job = await Job.findByIdAndDelete(req.params.id);
    if (!job) return res.status(404).json({ message: 'Job not found.' });
    return res.json({ message: 'Job deleted successfully.' });
  } catch (error) {
    return res.status(500).json({ message: 'Failed to delete job.', error: error.message });
  }
});

module.exports = router;
