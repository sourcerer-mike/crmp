# Customer

The mostly used entity referring to plenty others is the customer itself.


## Properties

- Timestamp when this customer has been created.
- Firm of the company.
- Timestamp when the customer has been edited.

When the customer is created the "created at" field will be filled automatically with the current date and time.

Companies usually have a title/name/firm that they are known by.
The "name" field is mend for the full title of a company as registered by the state.
A name can be 255 chars long and are treated as unique.
So when you try to store a company that already exists an error might be thrown.

You might want to track when the latest change has happened,
to keep your data up-to-date or filter out old customer.
Every time a customer information is changed,
the date and time is stored.
