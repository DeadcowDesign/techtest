# Supermetrics Technical Assesment
## Methodology and Justification

Post gathering and parsing is performed server-side. As the post return from the API is monolithic (it includes all posts for all users) - this would enable us to add a caching system for large data-sets that do not regularly change. It also allows us to sort and cache subsets of the data for faster processing (for example, sorting by user). _Note that I will not provide a cache system for the purposes of this technical test as it is out of scope, however, I would perform this by writing flat json files which could be checked for validity and returned in favour of an API call._

The application is built using TDD, with tests and scope being defined before code is written to ensure that code is robust.

## Application Structure
### Server-side
* Application
  * PHP Application files - Note that this folder and its contained files are uppercased to allow it to work with a minimal config SPL Autoloader and PSR-2 coding guidelines. This also separates the Application in the structure from the other files.
* tests
  * PHP - PHP Unit tests
### Client-side
* src 
  * SCSS files
  * raw JS files

  * Front end Unit tests
* js
  * parsed Javascript files
* css 
  * parsed css files
