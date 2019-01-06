# Wordpress Custom Post Type library


## Changelog

### 05.10.2018 - 0.0.0.0

- initial version
- Basic functionality for the "Project" post type, which means the basic classes to only actually register the post 
type in wordpress

### 05.10.2018 - 0.0.0.1

- Added a static util class "PostUtil", which will contain general purpose functions for working with wp posts.
already contains the following functions.
    - A function, which checks, if a post of the given ID exists
    - A function, which checks if the post of the given ID is of the given post type
- A Interface for all post wrapper classes
- A abstract base class for post wrapper classes, which implements the interface
- Moved the project post wrapper to inherit from the abstract base class
- Added a constructor to the project post wrapper class 

### 11.11.2018 - 0.0.0.2

- Added a Interface "Shortcode" for writing shortcode classes 

### 20.11.2018 - 0.0.0.3

- Added a utility function which returns HTML code for the permalink to a post, based on the ID

### 06.11.2018 - 0.0.0.4

- Added a utility function to map an un-nested array onto a new array structure with new and possibly nested key names. 
This is primarily needed when mapping the custom post type specific arguments to the actual array needed to perform a 
wordpress post insert.