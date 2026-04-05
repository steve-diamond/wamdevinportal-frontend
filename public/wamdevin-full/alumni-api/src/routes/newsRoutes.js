const express = require('express');
const News = require('../models/News');
const { protect, authorize } = require('../middleware/auth');

const router = express.Router();

router.get('/', protect, async (req, res) => {
  try {
    const newsItems = await News.find().populate('author', 'name email').sort({ date: -1 });
    return res.json(newsItems);
  } catch (error) {
    return res.status(500).json({ message: 'Failed to fetch news.', error: error.message });
  }
});

router.get('/:id', protect, async (req, res) => {
  try {
    const news = await News.findById(req.params.id).populate('author', 'name email');
    if (!news) return res.status(404).json({ message: 'News item not found.' });
    return res.json(news);
  } catch (error) {
    return res.status(500).json({ message: 'Failed to fetch news item.', error: error.message });
  }
});

router.post('/', protect, authorize('admin'), async (req, res) => {
  try {
    const payload = {
      ...req.body,
      author: req.user._id,
    };
    const news = await News.create(payload);
    return res.status(201).json(news);
  } catch (error) {
    return res.status(400).json({ message: 'Failed to create news item.', error: error.message });
  }
});

router.put('/:id', protect, authorize('admin'), async (req, res) => {
  try {
    const news = await News.findByIdAndUpdate(req.params.id, req.body, {
      new: true,
      runValidators: true,
    });
    if (!news) return res.status(404).json({ message: 'News item not found.' });
    return res.json(news);
  } catch (error) {
    return res.status(400).json({ message: 'Failed to update news item.', error: error.message });
  }
});

router.delete('/:id', protect, authorize('admin'), async (req, res) => {
  try {
    const news = await News.findByIdAndDelete(req.params.id);
    if (!news) return res.status(404).json({ message: 'News item not found.' });
    return res.json({ message: 'News item deleted successfully.' });
  } catch (error) {
    return res.status(500).json({ message: 'Failed to delete news item.', error: error.message });
  }
});

module.exports = router;
