from flask import Flask, request, send_file
from flask_cors import CORS
import yt_dlp
import os
import uuid

app = Flask(__name__)
CORS(app)

@app.route('/download', methods=['POST'])
def download():
    url = request.form.get('url')
    if not url:
        return "Missing URL parameter", 400
        
    os.makedirs('temp', exist_ok=True)
    file_id = str(uuid.uuid4())
    output_tmpl = f'temp/{file_id}.%(ext)s'
    
    ydl_opts = {
        'format': 'bestvideo[ext=mp4]+bestaudio[ext=m4a]/best[ext=mp4]/best',
        'outtmpl': output_tmpl,
        'merge_output_format': 'mp4',
        'quiet': True,
        'no_warnings': True
    }
    
    try:
        with yt_dlp.YoutubeDL(ydl_opts) as ydl:
            info = ydl.extract_info(url, download=True)
            title = info.get('title', 'video')
            filename = f"temp/{file_id}.mp4"
            
            if os.path.exists(filename):
                return send_file(
                    filename, 
                    as_attachment=True, 
                    download_name=f"{title}.mp4", 
                    mimetype='video/mp4'
                )
            else:
                return "Processing Error", 500
    except Exception as e:
        return f"Scraper Error: {str(e)}", 500

if __name__ == '__main__':
    port = int(os.environ.get("PORT", 5000))
    app.run(host='0.0.0.0', port=port)
