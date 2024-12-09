from flask import Flask, jsonify, request
from dotenv import load_dotenv
import mysql.connector
import os

load_dotenv()

app = Flask(__name__)

db_config = {
    'host': os.getenv('DB_HOST'),
    'user': os.getenv('DB_USERNAME'),
    'password': os.getenv('DB_PASSWORD'),
    'database': os.getenv('DB_DATABASE')
}

def get_db_connection():
    return mysql.connector.connect(**db_config)

@app.route('/api/students', methods=['GET'])
def get_students():
    conn = None  # Initialize conn here
    cursor = None # Initialize cursor here
    try:
        conn = get_db_connection()
        cursor = conn.cursor(dictionary=True)
        cursor.execute("SELECT * FROM students")
        students = cursor.fetchall()
        return jsonify(students)
    except Exception as e:
        return jsonify({'error': str(e)}), 500
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

@app.route('/api/students/<int:student_id>', methods=['PUT'])
def update_student_score(student_id):
    conn = None  # Initialize conn here
    cursor = None  # Initialize cursor here
    try:
        data = request.get_json()
        score = data.get('score')
        conn = get_db_connection()
        cursor = conn.cursor()
        cursor.execute("UPDATE students SET score = %s WHERE id = %s", (score, student_id))
        conn.commit()
        return jsonify({'message': 'Score updated successfully'})
    except Exception as e:
        return jsonify({'error': str(e)}), 500
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

if __name__ == '__main__':
    app.run(debug=True, port=5001)  # Run on port 5001