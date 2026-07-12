# Video Downloader Backend

This repository contains a Flask backend server for downloading videos using `yt-dlp` and serving them as MP4 files.

## Files

- `main.py` - Flask server handling `/download` POST requests.
- `requirements.txt` - Python dependencies.
- `Dockerfile` - Docker build instructions including FFmpeg.
- `video-scraper.php` - WordPress plugin file using the `/download` backend endpoint.

## Deploy to Render

1. Push this repository to GitHub.
2. Go to https://render.com and sign in.
3. Create a new Web Service.
4. Connect Render to this GitHub repo.
5. Render should detect the `Dockerfile` automatically.
6. Deploy and take note of the live URL.

## WordPress Plugin

In `video-scraper.php`, replace:

```php
$backend_url = 'https://YOUR-APP-NAME.onrender.com/download';
```

with your Render app URL, e.g.

```php
$backend_url = 'https://my-video-scraper.onrender.com/download';
```

Then use the shortcode `[python_downloader]` in your WordPress page.
