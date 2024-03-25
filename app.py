from flask import Flask, request, jsonify
from openai import Completion, OpenAI

# Create an instance of the Flask application
app = Flask(__name__)

# Create an instance of the OpenAI class with your API key
openai_api = OpenAI(api_key='key')

@app.route('/')
def index():
    return open('budgetP.html').read()

@app.route('/get_recommendations', methods=['POST'])
def get_recommendations():
    data = request.json
    # Extract relevant information from the request
    budget = data['budget']
    theme = data['theme']
    num_guests = data['numGuests']
    services = data['services']

    # Call OpenAI API to generate recommendations
    response = openai_api.create_completions(
        engine="text-davinci-002",
        prompt=f"Given the budget of {budget}, and desired services {services}, distribute the percentages of the budget based on desired services.",
        max_tokens=100,
        n=1,
        stop=None,
        temperature=0.7
    )

    return jsonify({'response': response.choices[0].text})

if __name__ == '__main__':
    app.run(debug=True)
