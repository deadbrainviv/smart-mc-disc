# smart-mc-disc
Custom implementation of GSMA MobileConnect PHP Based requests for authentication 

Programming Language: PHP
Development Infra: Apache, PHP, Ubuntu 
Service: MobileConnect by GSMA (mobileconnect.io)

There are 6 main File in this PHP example
should be used in conjunction of the Android client.

* mobileConnect.php
  *The is the main class object that contains all the function required to perform mobile connect requests.
* config.php
  *A simple file that contains the discovery credentials and endpoint that will be used by the main class file.
* redirect_recieve.php
  *Get response from endpoints and handle the requests accordingly. // Rename this file to the name of your redirect URL file name. // Use this code in your redirect page..
* start_mc.php
  *Construct the Mobile Connect Auth URL and redirect the "User-Agent" to it.
* callback.php
  *Manage the callback of the OIDC requests. 
* index.php
  *The landing page that identifies if you are using mobile network or not and routes you accordingly.

### High Level Flow - PHP Server Client Process
1. A client browser requests https://49.204.81.39/iqssmcendpoint/ 
2. If ip lookup is True (Mobile network), goto step 3, else go to step 4
3. Start request to "start_mc.php?session_id=xxxxx". This will call the Auth URL and using header enrichment, the server returns code and scope, goto step 5
4. Start request to "start_mc.php?session_id=xxxxx". encrypted msisdn using login hint. This will call the Auth URL and using standard procedure, the server returns code and scope, goto step 5
5. A token call is made and redirected to redirect URL. Based on the response, identified as a valid response, user info is requested
6. Requested user info parameter will be processed, parsed and user will be shown the success message
7. The Message will contain the MSISDN and PCR.


Result

![Alt text](pocusingmobnw.png?raw=true "From Mobile Network")
![Alt text](pocusingwifi.png?raw=true "From WiFi Network")
