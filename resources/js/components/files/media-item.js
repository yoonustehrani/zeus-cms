import React, { Component } from 'react'

export default class MediaItem extends Component {
    render() {
        let { id, path, thumbnail_path, name, ext, deleted_at, deleteFile } = this.props
        return (
            <div className="media-item mt-4 col-4 col-md-3 col-lg-2 p-1">
                <div className="img-container col-12 p-0">
                    <img src={`${APP_PATH}${thumbnail_path}`} />
                    <div className="data-container text-center col-12">
                        <p>
                            <a href={`${APP_PATH}${path}`} target="_blank" className="btn btn-outline-warning m-1">
                                <i className="fas fa-eye"></i>
                            </a>
                            <button className="btn btn-outline-info m-1"><i className="fas fa-info"></i></button>
                            <button className="btn btn-outline-danger m-1" onClick={() => deleteFile(id, Boolean(deleted_at))}>
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
