# 🌱 EcoHunt: Clean the World, One Click at a Time

EcoHunt is a web app built for a 2023–2024 hackathon. Instead of hunting imaginary creatures like in PokemonGo, volunteers claim real-world "bounties" to clean up trash and debris from locations on an interactive map, verify their cleanup with a photo, and get recycling advice from an AI chatbot (in Burmese).

## Features

- **Accounts** — sign up / log in, session-based auth.
- **Interactive map** (Leaflet + OpenStreetMap) — bounty markers show a title, coin reward, and difficulty. Click a marker to accept the bounty.
- **Image verification** — upload an "after" photo of a cleaned-up bounty; an AI vision model checks whether it's actually clean before marking it claimed.
- **AI recycling chat** — ask recycling questions (with or without a photo) and get advice back in Burmese, powered by Google's Gemini API.
- **Quests** — daily tasks and achievements tied to your account.

## Tech stack

- **Web app**: PHP + MySQL (auth, map, quests, about page), plain HTML/CSS/JS, Leaflet for maps.
- **AI services**: Python + Streamlit, using the Gemini API (`google-genai`) for both the chat and the image-verification features. Served as two small standalone apps, embedded into the PHP pages via iframe.

## Project structure

```
EcoHunt/
├── web/              # The PHP/HTML site — served by Apache as the document root
│   ├── classes/      # DB connection + auth logic (login/signup)
│   ├── leaflet/      # Leaflet.js library (vendored)
│   ├── marker_pages/ # One page per map bounty, embeds the Verify app
│   ├── images/       # Reference photos for each bounty
│   └── markers.json  # Bounty data (location, title, bounty, difficulty, status)
├── ai/               # Python/Streamlit apps
│   ├── aiChat.py     # Recycling chatbot
│   ├── verifyPage.py # Photo-based bounty verification
│   └── .streamlit/config.toml
├── schema.sql        # MySQL schema — import this to create the database
├── requirements.txt  # Python dependencies
├── start.bat         # Launches both Streamlit apps
└── secrets.bat.example
```

## Setup

You'll need **XAMPP** (or any Apache + PHP + MySQL stack) and **Python 3.10+**.

### 1. Clone the repo

```bash
git clone https://github.com/ingyinnnk/ecohunt.git
```

### 2. Set up the web app (PHP + MySQL)

1. Point your Apache **DocumentRoot** at the `web/` folder (not the repo root).
2. Start Apache and MySQL.
3. Import the schema:
   ```bash
   mysql -u root < schema.sql
   ```
   This creates the `ecohunt_db` database and the `users` table. `web/classes/connect.php` connects as `root` with no password by default (XAMPP's default) — edit it if your MySQL setup differs.
4. Visit the site in your browser (e.g. `http://localhost:8080/`) and sign up for an account.

### 3. Set up the AI services (Python + Gemini)

1. Create a virtual environment and install dependencies:
   ```bash
   python -m venv venv
   venv\Scripts\pip install -r requirements.txt
   ```
2. Get a free Gemini API key (no credit card required) from [aistudio.google.com/apikey](https://aistudio.google.com/apikey).
3. Copy `secrets.bat.example` to `secrets.bat` and paste your key in:
   ```bat
   set GEMINI_API_KEY=your_key_here
   ```
   `secrets.bat` is gitignored — never commit real keys.
4. Run `start.bat` from the repo root. This launches:
   - the recycling chatbot on `http://localhost:8501`
   - the bounty-photo verifier on `http://localhost:8502`

   The PHP pages (`web/aichat.php`, `web/marker_pages/*.html`) embed these via iframe automatically — just make sure the ports match.

### Notes

- Passwords are hashed (`password_hash`/`password_verify`); all DB queries use prepared statements.
- The AI features require both a valid `GEMINI_API_KEY` and both Streamlit apps running — if a page shows a "not set" error or the iframe doesn't load, check `start.bat` actually launched both consoles.

## Team

Built at a 2023–2024 hackathon by:

- **Mai** — Accounts & security
- **Sulica** — Frontend & Quests
- **Saw** — Frontend & design
- **KhonArr** — AI & map

## Reviving this project (2026)

This project sat untouched for about two years after the hackathon. Getting it running again meant fixing a fair amount that was either broken from the start or had simply rotted:

- There was no database schema anywhere in the repo, and a table-name mismatch (`user` vs `users`) meant the About Us page could never actually load data.
- Login and signup built SQL queries by string concatenation (SQL-injectable) and stored passwords in plaintext. Both now use prepared statements and `password_hash`/`password_verify`.
- The AI Chat and photo-verification features had the hackathon venue's local network IP (`172.16.0.17`) hardcoded into an iframe — meaning they could never work anywhere else. Both now point at `localhost`.
- A live API key was hardcoded directly in the Python source. It's been pulled out into an environment variable, and the whole AI backend was migrated off the original provider (Replicate, whose free credits were long gone) onto Google's Gemini API, which has a genuinely free tier.
- The map rendered completely blank unless the browser's geolocation resolved first — which never happens over plain HTTP in production. It now has a sane default view.
- Several nav links across the site pointed at dead `#` anchors instead of pages that already existed (Quest, Our Aim), and the Quest page's layout was broken (checkboxes floating away from their tasks, the nav bar hidden behind the page content).
- The flat file layout has been reorganized into `web/` (the PHP site) and `ai/` (the Streamlit services) for clarity.

---

🌿 **EcoHunt**: Making the world a cleaner place, one click at a time.
