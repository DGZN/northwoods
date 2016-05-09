
1. Form submit buttons don't work on tablets

    30. Mins

2. “Login” page:

  30. Mins

  1. From IP “68.112.195.6” allow login by employee PIN only (remove email and password fields)

  2. Require standard email and password for login from any other IP address


  <!--

3. Change main nav:
  ◦ Sale
  ◦ Reservations
  ◦ Admin
    ▪ Sale History
    ▪ Corporate Accounts
    ▪ Products
    ▪ Product Groups
    ▪ Product Types
    ▪ Product Modifiers (new)
    ▪ Tour Times
    ▪ Employees
    ▪ Customers
    ▪ Settings -->

4. “Sales” page:

  4 HOURS

  <!-- 1. show new sale form immediately
  2. Remove sale history -->
  <!-- 3. Remove any time-based reservations from available products -->
  <!-- 4. Allow for addition of multiple products for purchase -->
  <!-- 5. Allow for removal of selected products -->
  <!-- 6. Allow for selection of product options (ie: size:: XL, L, M, S | color: black, blue, green) -->
  7. Allow manager override of price of products
  <!-- 8. Remove empty field -->
  9. Auto-format input numbers as float with two decimal places
  <!-- 10. Change “change due” amount if quantity changes after tendered amount entered -->
  <!-- 11. Credit Card payment option: -->
    <!-- 1. Remove any extra fields in the credit card payment type (ie: email) -->
    <!-- 2. Auto-populate “country” field with “United States” -->
    <!-- 3. Provide country dropdown with all countries (or remove this field entirely) -->
    <!-- 4. Ideally populate “city” and “state” based on zipcode provided (or remove if not required) -->
  <!-- 12. Complete “Card on File” option for payment → allow only cards on file for that day -->
  <!-- 13. Only show valid corporate accounts -->
  14. Allow for multiple transactions (ie: gift certificate for $10 + cash for remainder)
  <!-- 15. If discount applied, calculate remainder due -->
  <!-- 16. Require note for discount or void -->
  17. Allow for email receipt after transaction finished (prompt for email with “cancel” option)
  <!-- 18. Clear input fields for payment types when switching between types -->
  19. Reset form when canceling a sale or completing a sale

5. “Reservations” page:

  4. Hours

  <!-- 1. Remove date column (instead have it say “Today's Reservations: April 27, 2016) -->

  <!-- 2. For upcoming reservations only show tomorrows reservations (change header to “Tomorrow's Reservations:
  April 28, 2016) -->

  <!-- 3. Add ability to pick from calendar date to show future or past reservations → change header to “Reservations
  for May 5, 2016” -->

  4. Need to display each reservation type for the day (should be separate from each other)

  5. Adding a reservation:

    <!-- 1. add it to the date of reservations showing or allow selection of date
    2. Allow the choice of timed reservation and populate available times accordingly
    3. Only have tour start times throughout (end times no longer required)
    4. Do not use “Tier 1”, “Tier 2”, etc in time dropdown
    5. Do not allow text input into guest quantity field
    6. Primary guest is populating with an ID after changing field focus? → these guests should not be assumed
    to be in DB prior to this
    7. Do not assume cost is even dollar amount in “cost” field
    8. Prepopulate “cost” field with normal cost of tour based on tour type selected -->
    9. Add tax to amount entered → need ledger type of view so employees can see the subtotal, tax, and grand
    totals based on number of guests selected
    <!-- 10. Finish ability to create reservation from employee side
    11. Reset form if canceled or completed -->

  6. Clicking on a reservation row should show reservation details

    1. There may be multiple groups added to a single tour → need to show visually who is grouped together
      <!-- 1. Full contact info for primary -->
      2. Show which tour it is for
      3. Clear layout to show what guests have paid for other guests
      4. Clear headers for terms accepted, payment received, waiver received
      5. Add button next to each guest for employee to click to indicate they showed up for their tour
      2. There is no way to go back to the previous page when clicking into reservation detail → previous page
         may not be “today's” date if employee is checking future reservations

  7. Administrators frequently change a group from one tour to another time → need way to modify existing
     reservations

6. “Sales History” page:

  15. MINS

  <!-- 1. Only show the following columns in main view: -->
    <!-- ◦ Transaction ID
    ◦ Time
    ◦ Amount
    ◦ Employee -->

  1. HOUR

  <!-- 2. Clicking on row should show sale details
    ◦ Date and time
    ◦ Products purchased and their quantities
    ◦ Subtotal, sales tax, grand total -->
    <!-- ◦ Payment methods and amounts used -->
    ◦ with pin, managers should be able to apply refunds (full or partial)

  15. MINS

  <!-- 3. Sales should not be allowed to be deleted ever -->

  15. MINS

  <!-- 4. Sales should not be allowed to be added from this page -->

7. “Corporate Accounts” page:

  120. MINS

  1. Adding new corporate account:

    <!-- 1. Account number should be auto-generated (as a unique 8 digit number)
    2. “Organization” name field should be added -->
    <!-- 3. Payment terms dropdown added
      ▪ Invoice
      ▪ Card on File -->
    <!-- 4. Checkbox for tax exempt (and if checked, no tax charged for reservations or sales)
    5. Date range valid -->
    6. Reset form once submitted or when canceled

  2. Existing corporate accounts view:

    <!-- 1. Only headers should be “Account Number”, “Organization”, “Contact Name” (combine first and last for a
       full name), “Phone”, “Email”, -->

    <!-- 2. Clicking on row should show corporate detail page -->
      1. Any info should be editable
      2. Account can be soft-deleted here
      <!-- 3. List of all sales attributed to this account should be listed (same layout as “sales history” page -->

8. “Products” page:

  60. MINS

  <!-- 1. Headers should be “Group”, “Type”, “Name” and sort in that order
  2. Description is not necessary
  3. Prices should be floats with two decimal places -->

  4. Clicking on product row brings up product detail page

    1. All product info is editable and soft-deletable here
    2. Show stock level for each product modifier (and allow adjustment)

  5. Adding a new product:
    <!-- 1. Select “Group” and “Type” first -->
    <!-- 2. Remove description, Stock, SKU and Price -->
    <!-- 3. Add multiple sub-products based on available modifiers -->
      <!-- 1. Price per sub-product (ie: large could be more expensive than a small) -->
      2. Prices should be float with two decimals (only numbers allowed)
      <!-- 3. Input for available quantity per that modifier set -->
      4. Reset form on cancel or submit

9. “Product Modifiers” page

  60 MINS.

  <!-- 1. Ability to add modifier groups, such as “Size”, “Color”, etc -->
  <!-- 2. Ability to add modifiers to modifier groups, such as “Extra Large”, “Green”, etc -->
  3. Ability to edit or delete any modifier groups or modifiers

10. “Tour Times” page:

  60 MINS

  <!-- 1. Add “Product Type” header
  2. Show new tier names under “Tiers” → change this header to “Time Group” -->
  <!-- 3. Sort by Product Type then by time -->
  <!-- 4. Remove end times (only need start times) -->
  5. Ability to edit any times
  <!-- 6. Creating new time -->
    <!-- 1. Add new field at top for dropdown to select product type
    2. Remove “End Time”
    3. Change “Time Tier” to “Time Group” -->

11. “Employees” page:

  60. MINS

  <!-- 1. Remove “action” column -->
  <!-- 2. Add “Phone Number “column
  3. Add “Role” column (and show “Employee”, ”Manager”, or “Admin” for each employee) -->
  <!-- 4. Clicking on row takes you to employee detail -->

    1. Ability to edit any information or soft-delete
    <!-- 2. Add “Last Name” field -->
    <!-- 3. Add checkbox for “Offsite Access” (this determines whether they can log in outside the static IP) -->
    <!-- 4. Add field for PIN (min 4 digits to max 8 digits)
    5. Add field for phone number -->

  <!-- 5. For adding new employee, modify fields like editing employee detail page -->

12. “Customers” page:

  60. MINS

  <!-- 1. Only headers should be “First Name”, “Last Name”, “Phone”, and “Email”
  2. Un-bold “First Name” -->
  <!-- 3. Clicking on row shows customer detail -->
    1. Allow for editing any information or soft-deleting
    <!-- 2. Show full contact info here (including address) -->

13. “Settings” page:

  30. MINS

  <!-- 1. Change “Base Tax Rate” to “City Tax Rate”
  2. Change “Sales Tax Rate” to “State Tax Rate”
  3. Add large text area to enter “Terms” text → to be used during reservation process
  4. Add large text area to enter “Waiver” text → to be used during reservation process -->
