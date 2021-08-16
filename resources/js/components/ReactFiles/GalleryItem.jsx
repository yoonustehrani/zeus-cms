import React, { Component } from 'react';
import {toggleSelectFile, deleteFile, restoreFile} from './actions'
class GalleryItem extends Component {
    toggleCheck = (e) => {
        let {id, dispatch} = this.props;
        if(e.target !== e.currentTarget) return;
        dispatch(toggleSelectFile(id))
    }
    render() {
        let { id, path, thumbnail_path, name, ext, deleted_at, selected, dispatch, editFormUrl } = this.props 
        return (
            <div className="media-item mt-4 col-4 col-md-3 col-lg-2 p-1">
                <div className="img-container col-12 p-0">
                    <img src={`${APP_PATH}${thumbnail_path}`} />
                    <input type="checkbox" className={`${selected ? 'active' : ''}`} onChange={this.toggleCheck} checked={selected}/>
                    <div className="data-container text-center col-12" onClick={this.toggleCheck}>
                        <p>
                            <a href={`${APP_PATH}${path}`} target="_blank" className="btn btn-sm btn-outline-warning m-1" data-lity data-lity-desc={name}>
                                <i className="fas fa-eye"></i>
                            </a>
                            <a className="btn btn-sm btn-outline-info m-1" href={editFormUrl} data-lity><i className="fas fa-info"></i></a>
                            <button title={`delete ${deleted_at ? 'forever': ''}`} className="btn btn-sm btn-outline-danger m-1" onClick={() => dispatch(deleteFile(id, Boolean(deleted_at)))}>
                                <i className={`fas ${deleted_at ? 'fa-fire' : 'fa-trash'}`}></i>
                            </button>
                            {deleted_at &&
                                <button title="restore" className="btn btn-sm btn-outline-primary m-1" onClick={() => dispatch(restoreFile(id))}><i className="fas fa-undo"></i></button>
                            }
                        </p>
                        <br />
                        <p className="text-center text-small w-100">{name}.{ext}</p>
                    </div>
                </div>
            </div>
        )
    }
}

export default GalleryItem;