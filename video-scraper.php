<?php
/**
 * Plugin Name: Python Cloud Video Downloader
 * Description: High-powered video downloader running on a cloud Python engine. Use shortcode [python_downloader]
 * Version: 3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function render_python_downloader() {
    // ⚠️ REPLACE THIS URL WITH YOUR ACTUAL RENDER URL
    $backend_url = 'https://hhhh-bd9l.onrender.com/download';

    $html = '
    <div style="max-width: 500px; margin: 20px auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: sans-serif;">
        <h2 style="margin-top: 0; text-align: center; color: #333;">Universal Video Downloader</h2>
        <p style="text-align: center; color: #666; margin-bottom: 20px;">Paste a social media link below to instantly download the MP4 file.</p>
        
        <!-- This form bypasses WordPress entirely and sends the work straight to your Python server -->
        <form action="' . esc_url($backend_url) . '" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="url" name="url" placeholder="Paste TikTok, Instagram, YouTube, X link..." required 
                   style="width: 100%; padding: 12px; border: 2px solid #e1e1e1; border-radius: 6px; font-size: 16px; box-sizing: border-box;">
            
            <select name="resolution" style="width: 100%; padding: 12px; border: 2px solid #e1e1e1; border-radius: 6px; font-size: 16px; background: white;">
                <option value="max">Best available</option>
                <option value="1080p">1080p</option>
                <option value="720p">720p</option>
            </select>
            
            <button type="submit" 
                    style="background: #107c41; color: white; border: none; padding: 14px; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
                🚀 Download File
            </button>
        </form>
    </div>';

    return $html;
}

add_shortcode( 'python_downloader', 'render_python_downloader' );
