<img src="https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/fav_logo_size.jpg?raw=true" alt="Real Enquiries" align="right">

# CRM for Property Management - Real Enquiries &middot; [![Build Status](https://img.shields.io/travis/npm/npm/latest.svg?style=flat-square)](https://travis-ci.org/npm/npm) [![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://github.com/codeitamarjr/CRM-Real-State/blob/master/LICENSE)
> CRM Daft.ie Real Statement

This is a CRM for a Property Management to deal with enquiries from Daft.ie.

With this Web CRM it is possible to manage a high volume of enquiries that come trhough Daft.ie and do actions based on the message receveid by the applicant, the CRM can automatic respond to an enquiry with a Welcome Message asking for further details to help the agent make a decision, send invites for a viewing if the enquiry has been approved, and an automatic thank you for applying message for those who has been denied. It is possible to generate reports and export in a xls file.

## Features

Dashboard: Summarize all the enquiries in one screen with the total number of enquiries, the number of enquiries waiting to be answered, the ones that has been already answered with the approval status or the ones that has being denied; It is a snapshot of the current state of the enquiries, also it's possible to see the total of properties that has been added to the CRM, and the total of properties that has been rented.

Enquiries: This feature will show a list of all the messages that come trhough Daft.ie, the user can send and autamitic replies to the message, inviting the applicant to proceend and create a profile uploading the required documents or inviting the applicant to view the property.

Applicants: Here it'll be possible to see all the applicants that created their profiles and uploaded the required documents, the user can also send an email to the applicant with the message that he/she wants to send based on the templates to approve or deny. For those that has been approved the user can set has a tenant.

Units: The user can see all the units that has been added to the CRM, and the user can add new units to the CRM.

Tenants: Here it'll be possible to see all the tenants that have been added to the CRM.

Reports: This feature enable the user to export an excels file with the list of all enquiries and status;

Templates: This feature enables the user to change the template of the email that is send to the user when he applies, when he has been approved or denied;

Calendly: This feature enables the user to access a third party service to manage an agenda with the appointements for a view;

RTB: The user can check if an Eircode ir registered in the RTB, if it is registered it'll be possible to see the property details from the RTB inside the CRM.

## Extra

User ACL Control: This feature enables the user to control the access to the CRM, the user can control the access to the CRM by the user group, setting a group to view, or edit the content of the CRM.

Profile: Manages the users profile such a name and picture in the CRM;

Settings: All the settings from the CRM

Automail: Enable or disable automail messages from a new enquiry, approved and denied ones;

Getting E-mails: Set the time to fecth new enquiries;

Calendly: Set the calendly web address;

Search: This options enable the user to search enquiries by typying a word in the search bar, this option will search in the email and the name of the applicant;

### The Enviorement

The base enviorement to run the system it is:

Apache

PHP higher then 7 ( with IMAP library[to fecth emails into the DB])

MySQL or MariaDB with the CRM database

### How-To enable IMAP library on PHP

In linux the command line below will install the required module:

```comand
sudo apt-get install php-imap #To install imap modules

sudo phpenmod imap #To enable on PHP
```

### Menu Features

- Dashboard
- Enquiries
- Applications
- Tenants
- Units
- Reports
- Templates
- Calendly
- RTB

### User Menu

- Agent
- PRS Settings
- Create Property
- Property Settings
- Fetching E-mails
- System Settings
- Logout

### Tables on MySQL

## Screens and Layouts

This projects uses Bootstrap, custom CSS and custom JS to create the layout and the screens.

Welcome and Login Screen:
![Login Page](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/wemcome-page.png?raw=true "Login Page")
Dashboard screen:
![Dashboard Page](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/dashboard-page.png?raw=true "Dashboard Page")
Enquiries screen:
![Enquiries Page](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/enquiries-page.png?raw=true "Enquiries Page")
Search screen:
![Search Page](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/search-screen.png?raw=true "Search Page")
Reports screen:
![Reports Page](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/reports-page.png?raw=true "Reports Page")
Automail screen:
![Automail Page](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/automail-page.png?raw=true "Automail Page")
Calendly screen:
![Calendly Page](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/calendly-page.png?raw=true "Calendly Page")
Manage Property screen:
![Manage Property](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/manage-property.png?raw=true "Manage Property")
User Profile screen:
![User Page](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/profile-page.png?raw=true "User Page")
System Settings screen:
![Settings Page](https://github.com/codeitamarjr/CRM-Real-State/blob/master/assets/img/screens/system-settings-page.png?raw=true "Settings Page")
