
# ALPS Drupal Deployment Site

This is a custom Github pages site that allows the alps Drupal modules to get updated without hosting on drupal.org.


## New Releases ##
To create a new release, create a new file in the `_posts` folder with the file name in the format of `YEAR-MONTH-DAY-title.md`, and using the following frontmatter:

```
layout: release
title: ALPS for Drupal 7
date:   2017-06-22 09:49:05 -0400
categories: update alps_drupal7

drupal_name: alps
drupal_version: 7.x-2.0
drupal_tag: 7.x-2.0
drupal_version_major: 2
drupal_version_patch: 0
drupal_status: published
drupal_files:
  - download_link: http://cdn.adventist.io/alps/drupal/download.tar.gz
    archive_type: tar.gz
    date: ahash
    mdhash: 00a64ddf46cd05543084e6fd2fe1edda
    filesize: 392557
    file_date: 1503409745
  - download_link: http://cdn.adventist.io/alps/drupal/download1.zip
    archive_type: zip
    date: 1ahash
    mdhash: 100a64ddf46cd05543084e6fd2fe1edda
    filesize: 1392557
```
Use the body content as the notes for the release.

## Module Inclusion

For modules and themes hosted off drupal.org, Drupal allows for a custom project update url. Include the following code in the project `.info` file:
```
project status url = https://adventistchurch.github.io/alps-drupal/update
```

## Local Development

1. Install Jekyll and plug-ins in one fell swoop. `gem install github-pages` This mirrors the plug-ins used by GitHub Pages on your local machine including Jekyll, Sass, etc.
2. Clone down your fork `git clone https://github.com/yourusername/yourusername.github.io.git`
3. Serve the site and watch for markup/sass changes `jekyll serve`
4. View your website at http://127.0.0.1:4000/
5. Commit any changes and push everything to the master branch of your GitHub user repository. GitHub Pages will then rebuild and serve your website.

## Questions?

[Open an Issue](https://github.com/barryclark/jekyll-now/issues/new) and let's chat!


