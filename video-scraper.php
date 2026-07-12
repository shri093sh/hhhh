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
        <p style="text-align: center; color: #666; margin-bottom: 20px;">Paste one or more social media links below, then select which videos to download.</p>
        
        <form action="' . esc_url($backend_url) . '" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            
            <label for="uvd_urls_input" style="font-weight: 600; color: #333;">Paste a post URL, or multiple URLs (one per line):</label>
            <textarea id="uvd_urls_input" name="url" placeholder="Paste Instagram carousel or video links here..." required rows="4"
                      style="width: 100%; padding: 12px; border: 2px solid #e1e1e1; border-radius: 6px; font-size: 16px; box-sizing: border-box; resize: vertical;"></textarea>

            <button type="button" id="uvd_parse_btn"
                    style="background: #e1e1e1; color: #333; border: none; padding: 12px 15px; border-radius: 6px; font-size: 16px; cursor: pointer; font-weight: bold; white-space: nowrap; transition: background 0.2s; width: fit-content;">
                📋 Parse URLs
            </button>

            <div id="uvd_url_list" style="display: none; flex-direction: column; gap: 10px; padding: 15px; border: 1px solid #e1e1e1; border-radius: 8px; background: #fafafa;"></div>
            <div id="uvd_url_hint" style="color: #666; font-size: 14px;">After parsing, uncheck any carousel items or videos you do not want to download.</div>
            <div id="uvd_hidden_inputs"></div>

            <select name="resolution" style="width: 100%; padding: 12px; border: 2px solid #e1e1e1; border-radius: 6px; font-size: 16px; box-sizing: border-box; background: white; cursor: pointer;">
                <option value="max">Maximum Quality (Original)</option>
                <option value="1080p">Standard (1080p limit)</option>
                <option value="720p">Data Saver (720p limit)</option>
            </select>
            
            <button type="submit" id="uvd_submit_btn"
                    style="background: #107c41; color: white; border: none; padding: 14px; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
                🚀 Download Selected Videos
            </button>
        </form>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const parseBtn = document.getElementById("uvd_parse_btn");
            const urlsInput = document.getElementById("uvd_urls_input");
            const urlList = document.getElementById("uvd_url_list");
            const hiddenInputs = document.getElementById("uvd_hidden_inputs");
            const submitBtn = document.getElementById("uvd_submit_btn");
            const form = submitBtn.closest('form');

            function parseUrls(text) {
                return text
                    .split(/\r?\n/)
                    .map(line => line.trim())
                    .filter(line => line.length > 0);
            }

            function renderUrlList(urls) {
                urlList.innerHTML = '';
                hiddenInputs.innerHTML = '';

                if (!urls.length) {
                    urlList.style.display = 'none';
                    return;
                }

                urlList.style.display = 'flex';
                urls.forEach((url, index) => {
                    const id = `uvd_url_checkbox_${index}`;
                    const wrapper = document.createElement('label');
                    wrapper.style.display = 'flex';
                    wrapper.style.alignItems = 'center';
                    wrapper.style.gap = '10px';
                    wrapper.style.padding = '8px 10px';
                    wrapper.style.border = '1px solid #e1e1e1';
                    wrapper.style.borderRadius = '6px';
                    wrapper.style.background = '#fff';
                    wrapper.style.cursor = 'pointer';

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = id;
                    checkbox.checked = true;
                    checkbox.dataset.url = url;

                    const span = document.createElement('span');
                    span.style.color = '#333';
                    span.style.fontSize = '14px';
                    span.textContent = url;

                    wrapper.appendChild(checkbox);
                    wrapper.appendChild(span);
                    urlList.appendChild(wrapper);
                });
            }

            parseBtn.addEventListener('click', function() {
                const urls = parseUrls(urlsInput.value);
                renderUrlList(urls);
            });

            form.addEventListener('submit', function(event) {
                hiddenInputs.innerHTML = '';
                const checkboxes = urlList.querySelectorAll('input[type="checkbox"]');
                const selectedUrls = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedUrls.push(checkbox.dataset.url);
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = 'urls[]';
                        hidden.value = checkbox.dataset.url;
                        hiddenInputs.appendChild(hidden);
                    }
                });

                if (!selectedUrls.length) {
                    event.preventDefault();
                    alert('Please select at least one URL to download.');
                    return;
                }

                submitBtn.innerText = '⏳ Processing (Please wait...)';
                submitBtn.style.background = '#0b5b2f';
            });
        });
        </script>
    </div>';

    return $html;
}

add_shortcode( 'python_downloader', 'render_python_downloader' );
