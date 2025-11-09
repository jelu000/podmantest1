//import React from 'react'
import './ListTodos.css';

function ListTodos({ tasks, onDelete }) {

  console.log(tasks);

  // 1. KONTROLLERA OM TASKS ÄR EN ARRAY OCH INTE ÄR TOM
  if (!Array.isArray(tasks) || tasks.length === 0) {
    // Lägg till kontrollen här
    return <p>Inga uppgifter att visa. Lägg till en ny!</p>;
  }



  return (
    <div>
      <br />
      <h5>Lista att göra</h5>
      <ul className="todo-list">

        {/* 2. Använd Array.prototype.map() för att iterera över listan */}
        {tasks.map(task => (

          // 3. Varje element som skapas i en loop MÅSTE ha en unik 'key' 

          <li key={task.id} className={task.completed ? 'completed' : ''}>
            <span className='todo_title'> {task.title} </span>
            <button className="delete-button" onClick={() => onDelete(task.id)}>Radera</button>
          </li>

        ))}
      </ul>

    </div>
  )
}

export default ListTodos