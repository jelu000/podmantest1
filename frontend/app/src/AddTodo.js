import React, { Component } from 'react'

export class AddTodo extends Component {

    constructor() {
        super();
        this.state = {inittext: ""};
    }
  
    componentDidMount(){

    }
    componentDidUpdate(){
        console.log(this.state.inittext)
    }

    render() {
    return (
      <div>
        
        <form>
            Att göra: <input type='text' value={this.state.value} onChange={(e) => {this.setState({ inittext: e.target.value });}}></input>
            <br/>
            <input type='button' value='add'></input>
        </form>

      </div>
    )
  }

}
export default AddTodo