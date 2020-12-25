const express = require('express');
const {check, validationResult} = require('express-validator');
const app = express();

app.use(express.static('public'));
app.use(express.urlencoded({ extended: false }));

app.get('/', (request, response) => {
    response.redirect('/contactus.html');
});

app.post('/process', [
    check('firstname',
        'First Name cannot be blank.').isLength(1),
    check('lastname',
        'Last Name cannot be blank.').isLength(1),
    check('contactEmail', 'Invalid Email').isEmail(),
    check('contactMessage','Request must be from 10 to 200 chars.').custom(
        (value) => {
            return value.length === 0 || 
                (value.length >= 10 && value.length <= 200);
        }
    )
   
], (request, response) => {
    const errors = validationResult(request);

    if (errors.isEmpty()) {
        // code to process form goes here
        response.redirect('/success.html');
    } else {
        let msg = 'You have the following errors:<ol>';
        for (error of errors.array()) {
            msg += "<li>" + error.msg + "</li>";
        }
        msg += "</ol>";
        const html_process = `<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="normalize.css">
        <link rel="stylesheet" href="styles.css">
        <title>Oops!</title>
        </head>
        <body>
        <main>
            <h1>Form Errors</h1>
            ${msg}
            <a href="javascript:history.back()">Try again.</a>
        </main>
        </body>
        </html>`;
        response.status(200);
        response.send(html_process);
    }
    console.log(request.body);
    console.log(errors.array());
});

app.listen(8080);