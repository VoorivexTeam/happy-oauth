# OAuth Lab
This lab simulates common OAuth vulnerabilities, inspired by the Dirty Dance techniques. The setup addresses the following URL-leaking gadgets:
- Gadget 1: Weak or missing origin-check in postMessage listeners that may leak URLs
- Gadget 2: Exploits involving window.name:
    - Example 1: Stealing window.name data from a sandboxed iframe
    - Example 2: Using an iframe with XSS and a parent-origin check

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