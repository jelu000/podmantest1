import ListTodos from './ListTodos';
import AddTodo from './AddTodo';
import './App.css';

function App() {
  return (
    <div className="App">
      <header className="App-header">
        <h3>To Do</h3>
        <AddTodo />
        <ListTodos />

      </header>
    </div>
  );
}

export default App;
