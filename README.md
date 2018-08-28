## Merck Treatment Discontinuation: Quantitative Analysis
#### Job number: 18236NC
#### Author: David Millington, Havas Lynx
This website allows people to input clinic data and view reports based on that.  It includes a simple admin user management system.

## Updates
* Fixed question numbering - 9 become 7, 10 became 8 and 11 became 9
* Question 7 (new numbering) is no longer required to proceed to next page.  This was only required if they selected Other and then didn't fill in the revealed text field
* Added print styling for all question and chart page.  Question page could do with improvements.
* Added Print Record button to Records list
* Added Print Record page

## TODO
* Check in all browsers
* Complete "Benchmark" chart
* Separate "Records" CSS out of reports CSS file
* In Edge the key icon colors are not displayed when printing

We need to record the dropdown options they pick with each graph so when the PDF is generated it uses the same options
One (broken) idea is to generate an image whenever the option is changed but that does not work since the images are generated on the client side
Another idea is not to generate a PDF but just use a special print only page
Adam is talking about having it display in a popup window, like a print preview
Upvoted answer here shows way to fake zoomed out view: https://stackoverflow.com/questions/21668635/zoom-out-whole-website-using-jquery-or-css

I think the best solution is a two prong approach:
1) Ensure each page has print friendly CSS so they can be printed individually
2) Create a special "print only" report page which has questions and answers on one long page with print friendly CSS
The second option could open zoomed out in a popup like Adam wants and then auto-call the JS print function.  Hopefully the print CSS can cancel out the zoom code.


## Future Updates
* Use session/cookie to remember the users graph drop down selections for the next time they view a report
* Remove empty row at bottom of Overview chart.  It's there because we don't have any data for that row.
* Rollover image swap effect for other image buttons (print, records)
* Have an "Edit" button on the chart pages so can go back and edit a clinic's data
* Paging controls for "My Records" page
* Add progressive page loading system using "Frenzy TurboLinks" Laravel port and "animate.css"
  * https://github.com/turbolinks/turbolinks
  * https://github.com/frenzyapp/turbolinks
  * https://goiabada.blog/can-you-build-a-single-page-application-without-a-front-end-framework-6799cee03750
  * https://github.com/turbolinks/turbolinks/issues/293
  * https://github.com/frenzyapp/turbolinks/issues/13
* Problem: Full screen exits when we change page, sucks for a full screen app! For now I've commented out the Fullscreen related code in the app.blade file.  This can be fixed by using a progressive system like TurboLinks
* Add the ability to enable/disable user accounts instead of just deleting them.  The difference is that when a user is deleted then their records are also removed.
* Show a number indicator next to the top right Admin link showing how many newly registered user accounts are pending
* Email admin when there is a new user registration
* Make IVF cycle titles have alternate colors on the first chart page - Monitor this bug tracker to see when they add that feature to the latest build https://github.com/chartjs/Chart.js/issues/2442
* Would be nice to have an auto-complete for the clinic name based on the previous clinics they have entered (browser input history might cover this already)
* Admin log page - "Jack Jones created Clinic 'La La Land' for year 2018 - 10:10 20.20.2018"
* Add localisation support - https://laravel.com/docs/5.6/localization
* Link footer disclaimer to an actual page
* Implement a "You have unsaved changes" box for returning to menu from question pages
* Add "Delete" confirmations on the Admin pages (users/roles/permissions)
* Add delete option for records
* Move lots of the colors etc from the style sheets into the variables file to make it easier to make site wide visual updates