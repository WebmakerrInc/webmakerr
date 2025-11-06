# Deployment Checklist

This checklist summarizes the tasks required to ship new versions of the Webmakerr theme and the Ultimate Multisite plugin. Work through each section before tagging a release.

## 1. Pre-release Hygiene
- [ ] Review open issues and pull requests to ensure all committed work is included in the release scope.
- [ ] Confirm CI pipelines are green (`npm run build`, `npm run lint`, `composer test`, etc.).
- [ ] Verify local environment uses the intended WordPress, PHP, and node versions.
- [ ] Update documentation or onboarding notes impacted by this release.

## 2. Webmakerr Theme Update
### Versioning
1. [ ] Bump the `Version` header inside `theme/style.css`.
2. [ ] Update the `version` field in `theme/package.json` and regenerate `theme/package-lock.json` (e.g., run `npm install`).
3. [ ] Update any release references in `theme/README.MD` if badges or documentation mention the previous version.
4. [ ] Build production assets (`cd theme && npm run build`) and commit generated files in `theme/build/` or `theme/resources/` as required.

### Change Log
- [ ] Append the release notes to `theme/CHANGELOG.md` (create the file if it does not exist yet).
- [ ] Cross-post highlights to the GitHub release draft and marketing channels.

## 3. Ultimate Multisite Plugin Update
### Versioning
1. [ ] Update the plugin header (`Version` value) in `multisite/ultimate-multisite.php`.
2. [ ] Bump the `version` field in `multisite/composer.json` and regenerate `composer.lock` (`composer install` or `composer update --lock`).
3. [ ] Update the `version` field in `multisite/package.json` and `package-lock.json` (run `npm install` if frontend assets changed).
4. [ ] Review `multisite/README.md` for version references or compatibility badges and adjust as needed.

### Change Log
- [ ] Add a new entry to `multisite/CHANGELOG.md` summarizing features, fixes, and database or schema changes.
- [ ] Document database migrations, cron changes, or breaking updates in `multisite/DEVELOPER-DOCUMENTATION.md` when relevant.

## 4. Release Finalization
- [ ] Smoke-test the theme and plugin together on a staging network (registration flow, checkout, payment capture, admin screens).
- [ ] Tag releases in Git (`git tag vX.Y.Z` for the theme, `git tag multisite-vX.Y.Z` for the plugin) and push the tags.
- [ ] Publish GitHub releases with the compiled changelog entries and download links.
- [ ] Notify support, success, and marketing teams about the deployment window and notable changes.

Keep this checklist updated as processes evolve so future releases stay consistent and auditable.
