# Offer


An entity to manage your quotes and track them for each customer.


## Properties

- Quotation text.
- Value of the offer.
- Subject of the offer.
- Approval status.

Every offer shall be described in a large quotation text to let everyone (esp. the customer)
know what it's all about.
It can be a large text as large as your database can bare.

The price or quote value is given without taxes for a better internal workflow.
It can be any number with four digits and up to 16 decimals in total.

The offer subject is a title for the whole document
and reduces all it's content to a small text.
The text can be 255 characters long but should be short for a better understanding.

The status shows in which step the offer is.
It shall be extended via configuration at later time.
For now it only covers some common states.
