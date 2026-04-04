# WAMDIN Alumni Portal Frontend

React frontend for the WAMDIN Alumni Portal.

## Tech Stack
- React 18
- React Router DOM
- Axios
- Tailwind CSS

## Prerequisites
- Node.js 18+
- npm 9+
- Running backend API

## Environment Variables
Copy `.env.example` to `.env` and update values.

```bash
cp .env.example .env
```

Required variables:
- `REACT_APP_API_URL` (example: `http://localhost:5000`)

## Install
```bash
npm install
```

## Run
Development server:
```bash
npm start
```

Build:
```bash
npm run build
```

## Project Structure
- `src/` app entry, pages, and reusable components
- `components/` shared UI components
- `pages/` route-level pages
- `services/` API/service helpers
- `store/` state management helpers

## API Client
API base URL is configured in `src/api.js` using:
- `REACT_APP_API_URL`
- fallback: `http://localhost:5000`

## Notes
- Keep `.env` out of source control.
- `node_modules/` is ignored by `.gitignore`.
