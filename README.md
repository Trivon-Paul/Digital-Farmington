
# Digital Farmington Map

## Description
This project offers users the ability to view historically/culturally significate points of interest (POIs) in the 
farmington valley area. The map is rendered via the Google Maps API and displays POIs at their lat/long location.
The POIs that are displayed on the map can be filtered based on category (category filters on the side bar) and based on time period (sliding  timeline under map). The map can also me moved and zoomed to get a better view of specific regions.

The website also has a Admin panel which allows site administrators to add, edit, and remove POIs and categories.
Through the admin panel, admins can also add other admin users. Newly added in 2024 was the password recovery feature that
allows admins to rest their password through an email guided self-recovery processes.


## Table of Contents
1. [Project Structure](#structure)
2. [Setup Test Environment](#setup)
3. [Usage](#usage)
4. [App Features](#features)

## Structure
- css - Directory containing all css
- i - Direcotry that contains...code
    - DB - contains the DB connection information and logic
    - functions - seemingly random assorment functions
- js - Directory with...javascript
    - map_option.js - This is the file you need if you want to edit the map API options (such as zoom or origin point)
- adminModule - Direcotry containing code related to the admin panel
- poiModule - Directory contianing code related to the POI admin page
    - functions - Directory with helper functions relating to the poiList
        - poiTableFunction.php - Code that fetches data to display in the poiTable
    - poiList.php - Code that renders the actual POI table using the Datatables library
- login.php, logout.php, revcover.php
    - These files in the root dir are the login/logout/password reset pages

## Setup
1. Clone the repository from the reclaim hosting site.
2. Follow Triv's great video tutorial on setting up a XAMPP test environment.

## Usage
1. Open your web browser and go to `https://digitalfarmingtonmap.org/`.

## Features
- POI Map: Annotated and interactive map of POIs in the Farmintong valley area.
    - Filter based on time period and POI category
- POI Manager (Admin): Interactive table of all POIs that can be sorted searched and filtered.
    - POIs can be clicked to go to the spcific POI page to edit its information or delete it.
    - New POIs can be added by clicking the New POI button.
- Category Manager (Admin): Page that displays editable list of POI categories. POI categories can be added, edited, or removed here.
- Admin Manager (Admin): PAge that displays list of all Admin users. Admin users can be added, edited, or removed here.