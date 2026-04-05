WAMDEVIN Alumni API (Express + MongoDB)

Setup
1. Copy .env.example to .env
2. Update MONGODB_URI and JWT_SECRET in .env
3. Run npm install
4. Start MongoDB:
	- Option A (Docker): npm run mongo:up
	- Option B (Native): start local MongoDB service on 127.0.0.1:27017
5. Run npm run dev (or npm start)

Create First Admin
1. Run: npm run seed:admin -- admin@example.com StrongPassword123
2. Login with POST /api/auth/login using that email/password

Stop Docker Mongo
- Run: npm run mongo:down

Base URL
http://localhost:5000

Auth
POST /api/auth/register
POST /api/auth/login
GET  /api/auth/me

Users
GET    /api/users
GET    /api/users/:id
POST   /api/users            (admin)
PUT    /api/users/:id        (admin)
DELETE /api/users/:id        (admin)

Events
GET    /api/events
GET    /api/events/:id
POST   /api/events           (admin)
PUT    /api/events/:id       (admin)
DELETE /api/events/:id       (admin)

Jobs
GET    /api/jobs
GET    /api/jobs/:id
POST   /api/jobs             (admin)
PUT    /api/jobs/:id         (admin)
DELETE /api/jobs/:id         (admin)

News
GET    /api/news
GET    /api/news/:id
POST   /api/news             (admin)
PUT    /api/news/:id         (admin)
DELETE /api/news/:id         (admin)

Donations
GET    /api/donations
GET    /api/donations/:id
POST   /api/donations        (admin)
PUT    /api/donations/:id    (admin)
DELETE /api/donations/:id    (admin)

Authorization Header
Authorization: Bearer <jwt_token>

Notes
- Passwords are hashed with bcrypt before save.
- JWT payload contains user id and role.
- Role checks use middleware for admin-only write operations.
- Mongoose timestamps are enabled; createdAt is present on all required models.
