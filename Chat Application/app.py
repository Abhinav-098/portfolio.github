from flask import Flask, render_template
from flask_socketio import SocketIO, send, emit

app = Flask(__name__)
app.config['SECRET_KEY'] = 'mysecret'
socketio = SocketIO(app)

@app.route('/')
def index():
    return render_template('index.html')

@socketio.on('message')
def handle_message(message):
    print('Received message: ' + message)
    send(message, broadcast=True)

@socketio.on('private_message')
def handle_private_message(data):
    recipient = data['recipient']
    message = data['message']
    print(f'Received private message for {recipient}: ' + message)
    emit('message', message, room=recipient)

@socketio.on('join')
def on_join(username):
    print(f'{username} has joined the chat')
    emit('message', f'{username} has entered the chat', broadcast=True)

@socketio.on('disconnect')
def on_disconnect():
    print('A user has disconnected')
    emit('message', 'A user has left the chat', broadcast=True)

if __name__ == '__main__':
    socketio.run(app, debug=True)
