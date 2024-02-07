## Findings 

Can follow basic blog from here 
https://www.nidup.io/blog/manipulate-google-sheets-in-php-with-api

you need ssl to submit data 

I've request maximum data in a minitues that throw an error
https://cloud.google.com/docs/quota#requesting_higher_quota

Google Client Invalid JWT: Token must be a short-lived token  (if system time is not synced eg in your system have 03:20 PM but currently 03:30 PM then error might appear)
https://stackoverflow.com/questions/48056381/google-client-invalid-jwt-token-must-be-a-short-lived-token

I try with api keys from credentail but i couldn't write to sheet using that 
instead i created service account and share that sheet with my service account as editor bcs we are editing our data

