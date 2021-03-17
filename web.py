from flast import flask

app - Flask(__name__)

@app.route('/')
def index():
  return 'hello world'
