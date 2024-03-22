import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

def send_email(sender_email, sender_password, recipient_email, subject, body):
    # Set up the MIME
    message = MIMEMultipart()
    message['From'] = sender_email
    message['To'] = recipient_email
    message['Subject'] = subject

    # Add body to email
    message.attach(MIMEText(body, 'plain'))

    # Connect to the SMTP server
    server = smtplib.SMTP('smtp.mail.yahoo.com', 587)
    server.starttls()

    # Login to the email account
    server.login(sender_email, sender_password)

    # Send email
    server.sendmail(sender_email, recipient_email, message.as_string())

    # Quit the server
    server.quit()

# Example usage:
if __name__ == "__main__":
    # Set up email details
    sender_email = "cnuemaildockauth@yahoo.com"
    sender_password = ""
    recipient_email = "cnuemaildockauth@yahoo.com"
    subject = "LETS GO : PYTHONS EMAIL_SENDER>PY WORKDED!!!!!"
    body = "This is a test email sent from Python."

    # Send email
    send_email(sender_email, sender_password, recipient_email, subject, body)

