# Manual QA Checklist — Registration & Payments

Use this checklist to validate the critical signup and payment scenarios after deploying changes.

## Free Plan Signup
- [ ] Open the public registration URL (e.g. `/checkout/registration`).
- [ ] Select a free plan and complete the registration wizard.
- [ ] Confirm the success page displays the new customer details and site URL.
- [ ] Log into the WordPress dashboard with the newly created credentials to ensure the user is active.

## Paid Plan Signup
- [ ] Choose a paid plan that requires payment information.
- [ ] Provide valid billing details and select the manual/stripe test gateway.
- [ ] Verify that the payment completes without errors and the confirmation page lists the payment reference.
- [ ] Confirm that the associated membership is marked as active in the admin dashboard.

## Duplicate Email Handling
- [ ] Attempt to register using an email address that already belongs to an existing customer.
- [ ] Ensure the form shows a descriptive validation error and prevents submission.
- [ ] Confirm that no duplicate customer record is created in the admin area.

## Invalid Domain / Site Slug Validation
- [ ] Enter an invalid domain or site slug (e.g. contains spaces or disallowed characters).
- [ ] Confirm inline validation prevents advancing to the next step.
- [ ] Retest with a valid slug to make sure the form recovers correctly.

## Payment Failure & Recovery
- [ ] Configure a payment gateway scenario that forces a decline (e.g. Stripe test card `4000 0000 0000 0002`).
- [ ] Verify the user-friendly error message is shown and the checkout remains on the payment step.
- [ ] Retry with a valid test card and ensure the flow completes successfully.
- [ ] Check that no orphaned pending payments remain in the admin payment list after a retry.
