# osclass-gdpr
Based on the original Osclass GDPR plugin. Refactored, and compatible with osclass 5.1.

- GDPR checkbox

    Consent requires a positive opt-in. Don’t use pre-ticked boxes or any other method of default consent.
    Ask people to positively opt in.

- Right to erasure

    The GDPR introduces a right for individuals to have personal data erased.
    The right to erasure is also known as ‘the right to be forgotten’.
    Individuals can make a request for erasure verbally or in writing.
    You have one month to respond to a request.

- Right to data portability

    The right to data portability allows individuals to obtain and reuse their personal data for their own purposes across different services.
    It allows them to move, copy or transfer personal data easily from one IT environment to another in a safe and secure way, without affecting its usability.

This update adds a preferences popup to capture user cookie preferences, a means to disable/hide elements according to those preferences, and an admin process to email a user a dump of their data.

### User reset cookie preference
You can add: `<a href="javascript:$.gdprcookie.wipe();">Reset GDPR preferences</a>`
to a theme page, to allow the user to delete their saved cookie preference, in order to recreate it on their next visit to the site