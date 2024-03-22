import math 
import sys

def store_token_and_email(token, email):
    # Here, you can perform any operations you need with the token and email
    # For demonstration purposes, let's print them
    print("Token:", token)
    print("Email:", email)

if __name__ == "__main__":
    # Check if correct number of arguments are provided
    if len(sys.argv) != 3:
        print("Usage: python email_auth.py <token> <email>")
        sys.exit(1)

    # Retrieve token and email from command-line arguments
    token = sys.argv[1]
    email = sys.argv[2]

    # Call function to store token and email
    store_token_and_email(token, email)

