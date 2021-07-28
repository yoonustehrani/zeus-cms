import React, { Component } from 'react';

class Actions extends Component {
    constructor(props) {
        super(props)
        this.state = {
            selectedAction: "1",
        }
    }

    handleSelect = (e) => {
        this.setState({selectedAction: e.target.value})
    }

    handleActionSubmit = () => {
        this.props.bulkActions[Number(this.state.selectedAction) - 1].action()
    }
    render() {
        let {bulkActions, selectedItems} = this.props;
        return (
            <div className={`w-100 float-left p-3 bg-light ${selectedItems.length < 1 ? 'd-none' : ''}`}>
                <p className="float-left mr-2">Bulk Actions <span className="badge badge-pill badge-primary">{selectedItems.length}</span> :</p>
                <select className="float-left" onChange={this.handleSelect} value={this.state.selectedAction}>
                    {bulkActions.map((action, i) => (
                        <option key={i} value={i + 1}>{action.title}</option>
                    ))}
                </select>
                <button type="button" onClick={this.handleActionSubmit} className="btn btn-sm btn-outline-dark">submit</button>
            </div>
        );
    }
}

export default Actions;