# Customer Relationship Management Property Management CRM

This is a CRM for a Property Management to deal with enquiries from Daft.ie;

With this CRM it will be possible to manage a high volume of enquiries that come trhough Daft.ie and do actions based on the message receveid by the applicant, the CRM can automatic respond to the an enquiry, ask for further details to help the agent make a decision and send invites for a viewing, it is possible to generate reports in a xls file and visualize data from applicants and future tenants.

## Features

Dashboard: Summarize all the enquiries in one screen with the number of enquiries waiting to be answrered, the one that has been already answered with the approval status to invite for a viewing or the one that has being denied;

Enquiries: This feature will show a list of all the messages that come trhough Daft.ie in a specific mailbox and the user can change the status of this message for approved or denied based on the message from the enquiry; For each decision the CRM will send an automatic email to the sender of the enquiry with the outcome( If approved will be possivle to send a link for a third service to arrange a view for example and If it is denied it will send a denied message);

Reports: This feature enable the user to download excels file with the list of all enquiries and status;

Automail: This feature enables the user to change the template of the email that is send to the user when he applies, when he has been approved or denied;

Calendly: This feature enables the user to access a third party service to manage an agenda with the appointements for a view;

Extra:

Profile: Manages the users profile such a name and picture in the CRM;

Settings: All the settings from the CRM

Automail: Enable os disable automail messages from a new enquiry, approved and denied ones;

Getting E-mails: Set the time to fecth new enquiries;

Calendly: Set the calendly web address;

### The Enviorement

The base enviorement to run the system it is:

Apache

PHP ( with IMAP library[to fecth emails into the DB])

MySQL or MariaDB

### How-To enable IMAP library on PHP

In linux the command line below will install the required module:

sudo apt-get install php-imap #To install imap modules

sudo phpenmod imap

### Menu Features

- Dashboard
- Enquiries
- Reports
- Automail
- Calendly

### User Menu

- Profile
- Settings
- Logout

### Tables on MySQL
