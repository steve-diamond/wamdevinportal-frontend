const mongoose = require('mongoose');

const connectDB = async () => {
  try {
    const conn = await mongoose.connect(process.env.MONGODB_URI, {
      autoIndex: true,
    });
    console.log(`MongoDB connected: ${conn.connection.host}`);
  } catch (error) {
    console.error('MongoDB connection failed:', error.message);
    console.error('Troubleshooting: start MongoDB locally or run `docker compose up -d mongo` in alumni-api.');
    process.exit(1);
  }
};

module.exports = connectDB;
