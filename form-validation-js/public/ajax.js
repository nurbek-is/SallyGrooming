function checkAnswer(e) {
    const answer = document.getElementById('answer').value;
    const xmlhttp = new XMLHttpRequest();
    const output = document.getElementById("message");
    output.innerHTML = "validating...";
    xmlhttp.open("POST", '/process', true);
    xmlhttp.onreadystatechange = function() {
      console.log(xmlhttp.readyState);
      if (xmlhttp.readyState == XMLHttpRequest.DONE
          && xmlhttp.status == 200) {
        output.innerHTML = xmlhttp.responseText;
      }
    }
    xmlhttp.setRequestHeader('Content-Type',
      'application/x-www-form-urlencoded');
    xmlhttp.send('answer=' + answer);
  }
  
  window.addEventListener('load', function(e) {
    const btn = document.getElementById('btn');
    const answer = document.getElementById('answer');
    btn.addEventListener('click', checkAnswer);
  
    answer.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        checkAnswer(e);
        e.preventDefault();
      }
    });
  });