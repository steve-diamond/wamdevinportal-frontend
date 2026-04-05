const dotenv = require('dotenv');
const mongoose = require('mongoose');
const User = require('../src/models/User');

dotenv.config();

const run = async () => {
  try {
    if (!process.env.MONGODB_URI) {
      throw new Error('MONGODB_URI is missing in .env');
    }

    const emailArg = process.argv[2];
    const passwordArg = process.argv[3];

    if (!emailArg || !passwordArg) {
      throw new Error('Usage: npm run seed:admin -- admin@example.com StrongPassword123');
    }

    await mongoose.connect(process.env.MONGODB_URI);

    const existing = await User.findOne({ email: emailArg.toLowerCase() });
    if (existing) {
      existing.role = 'admin';
      if (existing.name === '') existing.name = 'Admin User';
      await existing.save();
      console.log('Existing user promoted to admin:', existing.email);
    } else {
      const admin = await User.create({
        name: 'Admin User',
        email: emailArg.toLowerCase(),
        password: passwordArg,
        graduationYear: new Date().getFullYear(),
        program: 'Administration',
        role: 'admin',
      });
      console.log('Admin created:', admin.email);
    }

    await mongoose.disconnect();
    process.exit(0);
  } catch (error) {
    console.error('Admin seed failed:', error.message);
    await mongoose.disconnect().catch(() => {});
    process.exit(1);
  }
};

run();
