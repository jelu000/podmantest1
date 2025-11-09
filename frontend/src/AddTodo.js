import React, { Component } from 'react'
import './AddTodo.css'
export class AddTodo extends Component {

 
  // 1. Initial State för input-fältet OBS behövs ingen constructor längre till klasscompnenter
  state = {
    title: ''
  }

  // 2. Hanterar ändringar i input-fältet
  handleChange = (e) => {
    // Uppdatera det lokala state:t (title)
    console.log(e.target.value);
    this.setState({ title: e.target.value });
  }

  // 3. Hanterar submit av formuläret
  handleSubmit = (e) => {
    e.preventDefault(); // Stoppa webbläsarens standardbeteende
    
    //Samma som: const title = this.state.title; FAST med fördel om man har flera state variabler
    const { title } = this.state;
    //console.log(`Title=${title}`)
    if (title.trim()) {
      // Kalla på den medskickade funktionen från App.js
      // Funktionen finns tillgänglig via props (this.props.onAdd)
      this.props.onAdd(title);

      // Rensa input-fältet lokalt
      this.setState({ title: '' });
    }
  }

  render() {
    return (
      <div className='add_maindiv'>

        <form className='todo_form' onSubmit={this.handleSubmit}>
          Att göra: <input className='todo_tf'  type='text' placeholder="Ny ToDo-uppgift..." value={this.state.title} onChange={this.handleChange}></input>
          <br />
          <button className='todo_addbutt' type='submit'>Lägg till</button>
          
        </form>

      </div>
    )
  }

}
export default AddTodo