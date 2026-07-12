<?php
/**
 * Plugin Name: Python Cloud Video Downloader
 * Description: High-powered video downloader with Paste button & Resolution picker.
 * Version: 3.2
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function render_python_downloader() {
    // ⚠️ REPLACE THIS URL WITH YOUR ACTUAL RENDER URL
    $backend_url = 'https://hhhh-bd9l.onrender.com/download';

    $html = '
    <div style="max-width: 500px; margin: 20px auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: sans-serif;">
        <h2 style="margin-top: 0; text-align: center; color: #333;">Universal Video Downloader</h2>
        <p style="text-align: center; color: #666; margin-bottom: 20px;">Paste a social media link below to instantly download the file.</p>
        
        <form action="' . esc_url($backend_url) . '" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            
            <div style="display: flex; gap: 10px; align-items: center;">
                <input type="url" id="uvd_url_input" name="url" placeholder="Paste TikTok, Instagram, YouTube link..." required 
                       style="flex-grow: 1; padding: 12px; border: 2px solid #e1e1e1; border-radius: 6px; font-size: 16px; box-sizing: border-box;">
                
                <button type="button" id="uvd_paste_btn"
                        style="background: #e1e1e1; color: #333; border: none; padding: 12px 15px; border-radius: 6px; font-size: 16px; cursor: pointer; font-weight: bold; white-space: nowrap; transition: background 0.2s;">
                    📋 Paste
                </button>
            </div>
            
            <!-- NEW: The Resolution Dropdown -->
            <select name="resolution" style="width: 100%; padding: 12px; border: 2px solid #e1e1e1; border-radius: 6px; font-size: 16px; box-sizing: border-box; background: white; cursor: pointer;">
                <option value="max">Maximum Quality (Original)</option>
                <option value="1080p">Standard (1080p limit)</option>
                <option value="720p">Data Saver (720p limit)</option>
            </select>
            
            <button type="submit" id="uvd_submit_btn"
                    style="background: #107c41; color: white; border: none; padding: 14px; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
                🚀 Download File
            </button>
        </form>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pasteBtn = document.getElementById("uvd_paste_btn");
            const urlInput = document.getElementById("uvd_url_input");
            const submitBtn = document.getElementById("uvd_submit_btn");

            pasteBtn.addEventListener("click", async () => {
                try {
                    const text = await navigator.clipboard.readText();
                    if (text) {
                        urlInput.value = text;
                    }
                } catch (err) {
                    alert("Your browser blocked clipboard access. Please right-click and paste manually.");
                }
            });

            submitBtn.addEventListener("click", function() {
                if (urlInput.value !== "") {
                    submitBtn.innerText = "⏳ Processing (Please wait...)";
                    submitBtn.style.background = "#0b5b2f";

                    setTimeout(() => {
                        submitBtn.innerText = "🚀 Download File";
                        submitBtn.style.background = "#107c41";
                    }, 5000);
                }
            });
        });
        </script>
    </div>';

    return $html;
}

add_shortcode( 'python_downloader', 'render_python_downloader' );
