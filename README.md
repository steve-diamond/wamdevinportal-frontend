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

## Production Domain Setup (`www.wamdevin.com`)
1. Deploy frontend to your host and map `www.wamdevin.com`.
2. Deploy backend to `api.wamdevin.com`.
3. Set frontend env:
	- `REACT_APP_API_URL=https://api.wamdevin.com`
4. Set backend env:
	- `CLIENT_URL=https://www.wamdevin.com`
	- `CLIENT_URLS=https://www.wamdevin.com,https://wamdevin.com`
5. DNS records:
	- `A`/`CNAME` for `www` to frontend host target
	- `A`/`CNAME` for `api` to backend host target
	- Optional redirect from apex `wamdevin.com` to `www.wamdevin.com`
