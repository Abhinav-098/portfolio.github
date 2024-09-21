    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the form data
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);
    
        // Create a timestamp for the message
        $timestamp = date('Y-m-d H:i:s');
    
        // Prepare the message content
        $content = "Name: $name\nEmail: $email\nMessage: $message\nTimestamp: $timestamp\n\n";
    
        // Open the file in append mode
        $file = fopen('messages.txt', 'a');
    
        // Check if the file was opened successfully
        if ($file === false) {
            die("Error opening file.");
        }
    
        // Write the content to the file
        if (fwrite($file, $content) === false) {
            die("Error writing to file.");
        }
    
        // Close the file
        fclose($file);
    
        // Redirect back to the form or show a success message
        header('Location: index.html?success=1');
        exit;
    } else {
        // If the request method is not POST, redirect back to the form
        header('Location: index.html');
        exit;
    }
    ?>
