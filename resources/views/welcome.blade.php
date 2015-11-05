<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet"
          type="text/css">
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <style>
        input, select {
            margin-top: 0.8em;
        }
        select {
            font-size: 1.7em;
        }
    </style>
</head>
<body>
<div class="container col-md-4 col-md-offset-4">

    <form class="form-sms" action="/sms" method="POST">
        <h2 class="form-sms-heading">Send SMS</h2>
        <label for="inputPhone" class="sr-only">Phone Number</label>
        <input type="text" id="inputPhone" class="form-control"
               placeholder="Cell Phone #, ex: 0955997887" required autofocus>
        <label for="inputMessage" class="sr-only">Message</label>
        <input type="text" id="inputMessage" class="form-control"
               placeholder="Enter your message" required>
        <label for="platform">Select Platform:</label>
        <select name="platform" id="platform">
            <option value="p1">p1</option>
            <option value="p2">p2</option>
            <option value="p3">p3</option>
        </select>
        <br/>
        <br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Send</button>
    </form>

</div> <!-- /container -->
</body>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</html>
