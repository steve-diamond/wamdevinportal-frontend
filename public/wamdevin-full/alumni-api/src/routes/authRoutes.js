const express = require('express');
const jwt = require('jsonwebtoken');
const User = require('../models/User');
const { protect } = require('../middleware/auth');

const router = express.Router();

const signToken = (id, role) =>
  jwt.sign({ id, role }, process.env.JWT_SECRET, {
    expiresIn: process.env.JWT_EXPIRES_IN || '7d',
  });

router.post('/register', async (req, res) => {
  try {
    const {
      name,
      email,
      password,
      graduationYear,
      program,
      profilePicture,
      bio,
      linkedIn,
    } = req.body;

    if (!name || !email || !password || !graduationYear || !program) {
      return res.status(400).json({ message: 'Missing required fields.' });
    }

    const existing = await User.findOne({ email: email.toLowerCase() });
    if (existing) {
      return res.status(409).json({ message: 'Email already in use.' });
    }

    const user = await User.create({
      name,
      email,
      password,
      graduationYear,
      program,
      profilePicture,
      bio,
      linkedIn,
    });

    const token = signToken(user._id, user.role);

    return res.status(201).json({
      message: 'Registration successful.',
      token,
      user: {
        id: user._id,
        name: user.name,
        email: user.email,
        role: user.role,
        graduationYear: user.graduationYear,
        program: user.program,
        profilePicture: user.profilePicture,
        bio: user.bio,
        linkedIn: user.linkedIn,
        createdAt: user.createdAt,
      },
    });
  } catch (error) {
    return res.status(500).json({ message: 'Server error.', error: error.message });
  }
});

router.post('/login', async (req, res) => {
  try {
    const { email, password } = req.body;

    if (!email || !password) {
      return res.status(400).json({ message: 'Email and password are required.' });
    }

    const user = await User.findOne({ email: email.toLowerCase() }).select('+password');
    if (!user) {
      return res.status(401).json({ message: 'Invalid credentials.' });
    }

    const passwordOk = await user.matchPassword(password);
    if (!passwordOk) {
      return res.status(401).json({ message: 'Invalid credentials.' });
    }

    const token = signToken(user._id, user.role);

    return res.json({
      message: 'Login successful.',
      token,
      user: {
        id: user._id,
        name: user.name,
        email: user.email,
        role: user.role,
        graduationYear: user.graduationYear,
        program: user.program,
        profilePicture: user.profilePicture,
        bio: user.bio,
        linkedIn: user.linkedIn,
        createdAt: user.createdAt,
      },
    });
  } catch (error) {
    return res.status(500).json({ message: 'Server error.', error: error.message });
  }
});

router.get('/me', protect, async (req, res) => {
  return res.json({ user: req.user });
});

module.exports = router;
