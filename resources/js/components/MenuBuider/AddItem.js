import Axios from 'axios';
import React, { Component } from 'react';

class AddItem extends Component {
    constructor(props) {
        super(props);
        this.state = {
            title: "",
            url: "",
            route: "",
            parameters: "",
            icon_class: "",
            target: "_blank",
            saving: false,
        }
    }
    onTextStateChange = (stateParam, e) => {
        let updatedState = {};
        updatedState[stateParam] = e.target.value;
        this.setState(prevState => (updatedState))
    }
    onOptionChange = (e) => {
        let updatedState = {target: e.target.value}
        this.setState(prevState => (updatedState))
    }
    onClickSubmit = () => {
        let {Action, onSubmit} = this.props;
        let {title, url, route, parameters, icon_class, target} = this.state;
        this.toggleSaving();
        Axios.post(Action, {
            title: title,
            url: url,
            route: route,
            parameters: parameters,
            icon_class: icon_class,
            target: target
        }).then(res => {
            this.setState({
                title: "",
                url: "",
                route: "",
                parameters: "",
                icon_class: "",
                target: "_blank"
            })
            onSubmit(res.data);
            this.toggleSaving();
        })
    }
    toggleSaving = () => {
        this.setState(prevState => ({
            saving: ! prevState.saving
        }))
    }
    render() {
        return (
            <div className="col-12 float-left p-0 form-group">
                <div className="col-lg-4 col-md-6 col-12 float-left input-group mb-3">
                    <div className="input-group-prepend">
                        <span className="input-group-text"><i className="fas fa-font"></i></span>
                    </div>
                    <input type="text" className="form-control" placeholder="Title"
                    onChange={this.onTextStateChange.bind(this, 'title')} value={this.state.title}/>
                </div>
                <div className="col-lg-4 col-md-6 col-12 float-left input-group mb-3">
                    <div className="input-group-prepend">
                        <span className="input-group-text"><i className="fas fa-link"></i></span>
                    </div>
                    <input type="text" className="form-control" placeholder="URL"
                    onChange={this.onTextStateChange.bind(this, 'url')} value={this.state.url}/>
                </div>
                <div className="col-lg-4 col-md-6 col-12 float-left input-group mb-3">
                    <div className="input-group-prepend">
                        <span className="input-group-text"><i className="fas fa-network-wired"></i></span>
                    </div>
                    <input type="text" className="form-control" placeholder="Route"
                    onChange={this.onTextStateChange.bind(this, 'route')} value={this.state.route}/>
                </div>
                <div className="col-lg-4 col-md-6 col-12 float-left input-group mb-3">
                    <div className="input-group-prepend">
                        <span className="input-group-text"><i className="fas fa-icons"></i></span>
                    </div>
                    <input type="text" className="form-control" placeholder="Icon class e.g: fas fa-user"
                    onChange={this.onTextStateChange.bind(this, 'icon_class')} value={this.state.icon_class}/>
                </div>
                <div className="col-lg-4 col-md-6 col-12 float-left input-group mb-3">
                    <div className="input-group-prepend">
                        <span className="input-group-text"><i className="fas fa-external-link-alt"></i></span>
                    </div>
                    <select onChange={this.onOptionChange} className="form-control" value={this.state.target}>
                        {["_blank", "_self"].map((target, i) => {
                            return (
                                <option key={i} value={target}>{target}</option>
                            )
                        })}
                    </select>
                </div>
                <div className="col-lg-6 col-md-8 col-12 float-left input-group mb-3">
                    <textarea onChange={this.onTextStateChange.bind(this, 'parameters')} rows="6" className="json-code form-control bg-dark text-warning"/>
                </div>
                <div className="col-12 float-left">
                    <button onClick={this.onClickSubmit} disabled={this.state.saving} className="btn btn-success">
                        <i className={`fas fa-${this.state.saving ? 'upload' : 'save'}`}></i>
                    </button>
                </div>
            </div>
        );
    }
}

export default AddItem;