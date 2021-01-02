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
    console.log(errors.array());
    let msg;
    if (errors.isEmpty()) {
        msg = "<span class='valid'>Right On! " + "Good Job correctly filling it out</span>";
    } 
    else {
         msg = 'You have the following errors:<ol>';
        for (error of errors.array()) {
            msg += "<li>" + error.msg + "</li>";
        }
        msg += "</ol>";
            // <h1>Form Errors</h1>
            // ${<a href="javascript:history.back()">Try again.</a>}
       
        response.status(200);
        response.send(msg);
    
}
});

app.listen(8080);