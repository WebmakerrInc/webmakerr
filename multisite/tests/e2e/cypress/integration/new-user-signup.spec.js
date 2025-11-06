/**
 * Integration tests covering the new customer signup journey.
 *
 * The flow intentionally mirrors the primary checkout experience and
 * performs a post-signup login to confirm the account was provisioned.
 */

describe('New User Signup Smoke Test', () => {
  const timestamp = Date.now();
  const testCustomer = {
    username: `signup_user_${timestamp}`,
    email: `signup_user_${timestamp}@example.com`,
    password: 'SignupPassword123!',
    firstName: 'Cypress',
    lastName: 'Tester',
  };

  const testSite = {
    title: `Cypress Site ${timestamp}`,
    path: `cypress-site-${timestamp}`,
  };

  it('Registers a brand-new customer and validates login', () => {
    cy.visit('/checkout/registration');

    cy.get('[data-testid="pricing-table"], .wu-pricing-table, [id*="pricing"], [class*="plan"]')
      .should('be.visible')
      .first()
      .within(() => {
        cy.get('button, .wu-button, [type="submit"]').first().click();
      });

    cy.get('[data-testid="checkout-step"], .wu-step, [class*="step"]').should('contain.text', '2');

    cy.get('#username, [name="username"], [data-testid="username"]').clear().type(testCustomer.username);
    cy.get('#email, [name="email"], [data-testid="email"]').clear().type(testCustomer.email);
    cy.get('#password, [name="password"], [data-testid="password"]').clear().type(testCustomer.password);

    cy.get('body').then(($body) => {
      if ($body.find('#password_confirmation, [name="password_confirmation"], [data-testid="password-confirm"]').length) {
        cy.get('#password_confirmation, [name="password_confirmation"], [data-testid="password-confirm"]').clear().type(testCustomer.password);
      }
    });

    cy.get('body').then(($body) => {
      if ($body.find('#first_name, [name="first_name"], [data-testid="first-name"]').length) {
        cy.get('#first_name, [name="first_name"], [data-testid="first-name"]').clear().type(testCustomer.firstName);
      }
    });

    cy.get('body').then(($body) => {
      if ($body.find('#last_name, [name="last_name"], [data-testid="last-name"]').length) {
        cy.get('#last_name, [name="last_name"], [data-testid="last-name"]').clear().type(testCustomer.lastName);
      }
    });

    cy.get('[data-testid="continue-btn"], .wu-button, button[type="submit"]').contains(/continue|next|proceed/i).click();

    cy.get('[data-testid="checkout-step"], .wu-step, [class*="step"]').should('contain.text', '3');

    cy.get('#site_title, [name="site_title"], [data-testid="site-title"]').clear().type(testSite.title);
    cy.get('#site_url, [name="site_url"], [data-testid="site-url"], [name="blogname"]').clear().type(testSite.path);

    cy.get('body').then(($body) => {
      if ($body.find('[data-testid="template-selection"], .wu-template-selection, [class*="template"]').length) {
        cy.get('[data-testid="template-selection"], .wu-template-selection, [class*="template"]').first().click({ force: true });
      }
    });

    cy.get('[data-testid="continue-btn"], .wu-button, button[type="submit"]').contains(/continue|next|proceed/i).click();

    cy.get('body').then(($body) => {
      const hasPaymentForm = $body.find('[data-testid="payment-form"], [name*="card"], [name*="billing"], [data-testid*="gateway"]').length > 0;

      if (hasPaymentForm) {
        cy.log('Paid plan detected - completing manual payment');

        cy.get('body').then(($billing) => {
          if ($billing.find('[name="billing_address[address_line_1]"], [name="billing_address_line_1"]').length) {
            cy.get('[name="billing_address[address_line_1]"], [name="billing_address_line_1"]').type('123 Cypress Street');
            cy.get('[name="billing_address[city]"], [name="billing_city"]').type('Test City');
            cy.get('[name="billing_address[state]"], [name="billing_state"]').type('CA');
            cy.get('[name="billing_address[zip_code]"], [name="billing_zip"]').type('90001');
          }
        });

        cy.get('[data-testid="gateway-manual"], [value="manual"], [data-gateway="manual"]').first().click({ force: true });
        cy.get('[data-testid="complete-btn"], .wu-button, button[type="submit"]').contains(/complete|finish|pay|confirm/i).click();
      } else {
        cy.log('Free plan detected - finalising signup');
        cy.get('[data-testid="complete-btn"], [data-testid="continue-btn"], .wu-button, button[type="submit"]').contains(/complete|finish|create|continue/i).click();
      }
    });

    cy.url({ timeout: 45000 }).should('satisfy', (href) => /confirmation|thank|success/.test(href));

    cy.get('[data-testid="success-message"], .wu-success, .notice-success, [class*="success"]').should('be.visible');
    cy.get('body').should('contain.text', testCustomer.email);

    cy.visit('/wp-login.php');
    cy.get('#user_login').clear().type(testCustomer.username);
    cy.get('#user_pass').clear().type(testCustomer.password);
    cy.get('#wp-submit').click();

    cy.get('#wpadminbar', { timeout: 20000 }).should('be.visible');
  });
});
