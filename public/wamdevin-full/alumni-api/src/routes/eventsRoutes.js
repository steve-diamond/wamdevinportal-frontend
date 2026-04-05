const express = require('express');
const Event = require('../models/Event');
const { protect, authorize } = require('../middleware/auth');

const router = express.Router();

router.get('/', protect, async (req, res) => {
  try {
    const events = await Event.find()
      .populate('createdBy', 'name email')
      .populate('attendees', 'name email')
      .sort({ date: 1 });
    return res.json(events);
  } catch (error) {
    return res.status(500).json({ message: 'Failed to fetch events.', error: error.message });
  }
});

router.get('/:id', protect, async (req, res) => {
  try {
    const event = await Event.findById(req.params.id)
      .populate('createdBy', 'name email')
      .populate('attendees', 'name email');

    if (!event) return res.status(404).json({ message: 'Event not found.' });
    return res.json(event);
  } catch (error) {
    return res.status(500).json({ message: 'Failed to fetch event.', error: error.message });
  }
});

router.post('/', protect, authorize('admin'), async (req, res) => {
  try {
    const payload = {
      ...req.body,
      createdBy: req.user._id,
      attendees: req.body.attendees || [],
    };
    const event = await Event.create(payload);
    return res.status(201).json(event);
  } catch (error) {
    return res.status(400).json({ message: 'Failed to create event.', error: error.message });
  }
});

router.put('/:id', protect, authorize('admin'), async (req, res) => {
  try {
    const event = await Event.findByIdAndUpdate(req.params.id, req.body, {
      new: true,
      runValidators: true,
    });
    if (!event) return res.status(404).json({ message: 'Event not found.' });
    return res.json(event);
  } catch (error) {
    return res.status(400).json({ message: 'Failed to update event.', error: error.message });
  }
});

router.delete('/:id', protect, authorize('admin'), async (req, res) => {
  try {
    const event = await Event.findByIdAndDelete(req.params.id);
    if (!event) return res.status(404).json({ message: 'Event not found.' });
    return res.json({ message: 'Event deleted successfully.' });
  } catch (error) {
    return res.status(500).json({ message: 'Failed to delete event.', error: error.message });
  }
});

module.exports = router;
