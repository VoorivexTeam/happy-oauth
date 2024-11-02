# OAuth Lab
This lab simulates common OAuth vulnerabilities, inspired by the [Dirty Dance blog post](https://labs.detectify.com/writeups/account-hijacking-using-dirty-dancing-in-sign-in-oauth-flows/). The setup addresses the following URL-leaking gadgets:
- Gadget 1: Weak or missing origin-check in postMessage listeners that may leak URLs
- Gadget 2: Exploits involving window.name:
    - Example 1: Stealing window.name data from a sandboxed iframe (actually I coded [this similar case](https://ysamm.com/?p=763) by [Youssef Sammouda](https://x.com/samm0uda) which I think is better)
    - Example 2: Using an iframe with XSS and a parent-origin check

## Overl Description
The challenge includes three websites:

- Main Website: This site uses a pseudo OAuth login. After authentication, it issues a session for the user
- Provider Website: This site provides OAuth services that the main website relies on for authentication
- Sandbox Website: This is a sandboxed site that is out of scope (assume this is part of a bug bounty program)

The OAuth implementation does not strictly follow the protocol—for example, the `state` parameter is missing. However, the main functionalities and overall structure align with the original OAuth flow, making it suitable for this challenge. Please do not seek other vulnerabilities in the websites. If you do find any, only use them to chain attacks aimed at stealing the OAuth token. The primary objective of all examples is to demonstrate how to steal the user’s OAuth token.

## Setup and Installation

To set up the OAuth lab, follow these instructions:

Step 1: Build and Start the Docker Containers
Run the following command in your terminal to build and start the Docker environment:

```bash
docker compose up --build
```
Add the following lines to your `hosts` file:
```
127.0.0.1 lab-site.com
127.0.0.1 lab-provider.com
127.0.0.1 lab-sandbox.com
```
Once the setup is complete, you can access the lab environment at `http://lab-site.com:9000`
