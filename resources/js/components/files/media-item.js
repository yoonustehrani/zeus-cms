import React, { Component } from 'react'

export default class MediaItem extends Component {
    constructor(props) {
        super(props)
        this.state = {
            selected: false
        }
    }
    toggleCheck = (e) => {
        if(e.target !== e.currentTarget) return;
        this.setState({
            selected: ! this.state.selected
        })
    }
    render() {
        let { id, path, thumbnail_path, name, ext, deleted_at, deleteFile } = this.props
        return (
            <div className="media-item mt-4 col-4 col-md-3 col-lg-2 p-1">
                <div className="img-container col-12 p-0">
                    <img src={`${APP_PATH}${thumbnail_path}`} />
                    <input type="checkbox" className={`${this.state.selected ? 'active' : ''}`} onChange={this.toggleCheck} checked={this.state.selected}/>
                    <div className="data-container text-center col-12" onClick={this.toggleCheck}>
                        <p>
                            <a href={`${APP_PATH}${path}`} target="_blank" className="btn btn-sm btn-outline-warning m-1">
                                <i className="fas fa-eye"></i>
                            </a>
                            <button className="btn btn-sm btn-outline-info m-1"><i className="fas fa-info"></i></button>
                            <button className="btn btn-sm btn-outline-danger m-1" onClick={() => deleteFile(id, Boolean(deleted_at))}>
                                <i className="fas fa-trash"></i>
                            </button>
                        </p>
                        <br />
                        <p className="text-center text-small w-100">{name}.{ext}</p>
                    </div>
                </div>
            </div>
        )
    }
}
