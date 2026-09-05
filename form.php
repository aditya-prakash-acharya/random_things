<?php
// Configuration
$successMessage = "";
$errorMessages = [];
$formData = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => ''
];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($name)) {
        $errorMessages['name'] = "Name is required.";
    } else {
        $formData['name'] = htmlspecialchars($name);
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages['email'] = "A valid email is required.";
    } else {
        $formData['email'] = htmlspecialchars($email);
    }

    if (empty($subject)) {
        $errorMessages['subject'] = "Subject is required.";
    } else {
        $formData['subject'] = htmlspecialchars($subject);
    }

    if (empty($message)) {
        $errorMessages['message'] = "Message cannot be empty.";
    } else {
        $formData['message'] = htmlspecialchars($message);
        if (strlen($message) < 10) {
            $errorMessages['message'] = "Message must be at least 10 characters.";
        }
    }

    // Process if no errors
    if (empty($errorMessages)) {
        // Here you would normally send the email using mail() or a library
        // For this example, we just simulate success
        $successMessage = "Thank you, {$formData['name']}! Your message has been sent successfully.";
        
        // Reset form data on success
        $formData = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-color: #1f2937;
            --text-light: #6b7280;
            --border-color: #d1d5db;
            --error-color: #ef4444;
            --success-color: #10b981;
            --radius: 8px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
            color: var(--text-color);
        }

        p.subtitle {
            text-align: center;
            color: var(--text-light);
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--text-color);
        }

        input, textarea, select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 15px;
            transition: border-color 0.2s, box-shadow 0.2s;
            background-color: #fff;
            color: var(--text-color);
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .error-message {
            color: var(--error-color);
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .input-error input, .input-error textarea {
            border-color: var(--error-color);
        }

        .input-error .error-message {
            display: block;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: var(--primary-hover);
        }

        .alert {
            padding: 15px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid transparent;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-color: #a7f3d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border-color: #fca5a5;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Get in Touch</h1>
    <p class="subtitle">We'd love to hear from you. Fill out the form below.</p>

    <?php if ($successMessage): ?>
        <div class="alert alert-success">
            <?= $successMessage ?>
        </div>
    <?php elseif (!empty($errorMessages)): ?>
        <div class="alert alert-error">
            <ul style="margin-left: 20px; margin-top: 5px;">
                <?php foreach ($errorMessages as $err): ?>
                    <li><?= $err ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group <?= isset($errorMessages['name']) ? 'input-error' : '' ?>">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($formData['name']) ?>" placeholder="John Doe">
            <div class="error-message"><?= $errorMessages['name'] ?? '' ?></div>
        </div>

        <div class="form-group <?= isset($errorMessages['email']) ? 'input-error' : '' ?>">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email']) ?>" placeholder="john@example.com">
            <div class="error-message"><?= $errorMessages['email'] ?? '' ?></div>
        </div>

        <div class="form-group <?= isset($errorMessages['subject']) ? 'input-error' : '' ?>">
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($formData['subject']) ?>" placeholder="Project Inquiry">
            <div class="error-message"><?= $errorMessages['subject'] ?? '' ?></div>
        </div>

        <div class="form-group <?= isset($errorMessages['message']) ? 'input-error' : '' ?>">
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="How can we help you?"><?= htmlspecialchars($formData['message']) ?></textarea>
            <div class="error-message"><?= $errorMessages['message'] ?? '' ?></div>
        </div>

        <button type="submit" class="btn">Send Message</button>
    </form>
</div>

</body>
</html>