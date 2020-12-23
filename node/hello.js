// Require the http module
const http = require('http');

// Create the HTTP server
const server = http.createServer( function(request, response) {
    const head = {
        'Content-Type': 'text/plain'
    }
    // Send the response header to the request
    response.writeHead(200, head);
    // Send the response body and indicate that message is complete
    response.end('Hello, world!');
});

// Start the HTTP server listening for connections
server.listen(8080);