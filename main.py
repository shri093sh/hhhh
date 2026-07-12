from flask import Flask, request, send_file
from flask_cors import CORS
import yt_dlp
import os
import uuid
import re
import zipfile

app = Flask(__name__)
CORS(app)

def sanitize_filename(name):
    name = re.sub(r'[^A-Za-z0-9._-]+', '_', name)
    return name.strip('_')[:100]

@app.route('/download', methods=['POST'])
def download():
    urls = request.form.getlist('urls[]')
    resolution = request.form.get('resolution', 'max')

    if not urls:
        single_url = request.form.get('url')
        if single_url:
            urls = [single_url]

    if not urls:
        return "Missing URL parameter", 400

    os.makedirs('temp', exist_ok=True)

    if resolution == '720p':
        format_str = 'bestvideo[height<=720][ext=mp4]+bestaudio[ext=m4a]/best[height<=720][ext=mp4]/best'
    elif resolution == '1080p':
        format_str = 'bestvideo[height<=1080][ext=mp4]+bestaudio[ext=m4a]/best[height<=1080][ext=mp4]/best'
    else:
        format_str = 'bestvideo[ext=mp4]+bestaudio[ext=m4a]/best[ext=mp4]/best'

    downloaded_files = []

    try:
        for url in urls:
            file_id = str(uuid.uuid4())
            output_tmpl = f'temp/{file_id}.%(ext)s'

            ydl_opts = {
                'format': format_str,
                'outtmpl': output_tmpl,
                'merge_output_format': 'mp4',
                'quiet': True,
                'no_warnings': True
            }

            with yt_dlp.YoutubeDL(ydl_opts) as ydl:
                info = ydl.extract_info(url, download=True)
                title = info.get('title', 'video')
                filename = f"temp/{file_id}.mp4"

                if not os.path.exists(filename):
                    return "Processing Error", 500

                safe_title = sanitize_filename(title)
                downloaded_files.append((filename, f"{safe_title}.mp4"))

        if len(downloaded_files) == 1:
            filename, download_name = downloaded_files[0]
            return send_file(
                filename,
                as_attachment=True,
                download_name=download_name,
                mimetype='video/mp4'
            )

        zip_id = str(uuid.uuid4())
        zip_filename = f"temp/{zip_id}.zip"
        with zipfile.ZipFile(zip_filename, 'w') as zipf:
            for filepath, arcname in downloaded_files:
                zipf.write(filepath, arcname)

        return send_file(
            zip_filename,
            as_attachment=True,
            download_name='video-downloads.zip',
            mimetype='application/zip'
        )
    except Exception as e:
        return f"Scraper Error: {str(e)}", 500

if __name__ == '__main__':
    port = int(os.environ.get("PORT", 5000))
    app.run(host='0.0.0.0', port=port)
