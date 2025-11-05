<p align="center">
  <a href="https://webmakerr.com" target="_blank">
    <img src="https://webmakerr.com/logo.svg" width="200" alt="Webmakerr Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/WebmakerrInc/Webmakerr/releases/">
    <img src="https://img.shields.io/github/release/WebmakerrInc/Webmakerr?include_prereleases=&sort=semver" alt="GitHub release">
  </a>
  <a href="https://github.com/WebmakerrInc/Webmakerr/releases/">
    <img src="https://img.shields.io/github/downloads/WebmakerrInc/Webmakerr/total" alt="Total Downloads">
  </a>
  <a href="#license">
    <img src="https://img.shields.io/badge/License-GPL--2.0-blue" alt="License">
  </a>
</p>

## About Webmakerr

[Webmakerr](https://webmakerr.com) is a fast, modern, and fully customizable [WordPress](https://wordpress.org) theme built on [Tailwind CSS](https://tailwindcss.com).  
It’s designed for developers, agencies, and creators who want clean, efficient, and flexible workflows without the bloat.

Webmakerr gives you a blazing-fast foundation for building beautiful, responsive WordPress themes powered by Tailwind — with all the tools you need to go from concept to production.

To get started, visit the [Webmakerr documentation](https://webmakerr.com/docs).

---

## Features

- Built with Tailwind CSS  
- Modern development workflow  
- SEO-optimized and accessibility-ready  
- Lightweight and performance-focused  
- Developer-friendly structure with extendable hooks  

---

## Installation

Clone or download the repository, then install dependencies and build assets:

```bash
npm install
npm run build


## Theme License Activation

### WordPress Admin Flow
1. In the WordPress dashboard go to **Appearance → Theme License** (direct URL: `/wp-admin/themes.php?page=webmakerr-theme-license`).
2. Enter your license in the **License Key** field and click **Activate License**.
3. A success message confirms activation and the theme stores the option `webmakerr_theme_license_status` with the value `active`.

### Configuring the License Server
1. Upload the contents of the `/license-server` directory from this repository to your license server (for example `https://yourlicenseserver.com/`).
2. Add or update keys inside `license.json` using the format:
   ```json
   {
     "licenses": [
       "ABC123-XYZ789",
       "WEBMAKERR-001",
       "WEBMAKERR-002"
     ]
   }
   ```
3. Ensure `validate-license.php` is accessible at `https://yourlicenseserver.com/validate-license.php`. The script accepts either `POST` or `GET` requests with a `license_key` (or `key`) parameter and responds with JSON describing the activation result.
4. Point the theme to your server by defining the constant in `wp-config.php` (or a custom plugin):
   ```php
   define('WEBMAKERR_LICENSE_SERVER_URL', 'https://yourlicenseserver.com/validate-license.php');
   ```

### How Validation Works
- The admin page triggers a secure REST request (`wp_remote_post`) to `WEBMAKERR_LICENSE_SERVER_URL` with the license key and the site URL.
- The license server compares the submitted key against `license.json` and returns either:
  ```json
  { "status": "success", "message": "License activated successfully", "license_status": "active" }
  ```
  or
  ```json
  { "status": "error", "message": "Invalid license key", "license_status": "invalid" }
  ```
- When the response indicates success the key is saved in `webmakerr_theme_license_key` and the status is set to `active`. Errors leave the status as `invalid` so the admin can retry later.
