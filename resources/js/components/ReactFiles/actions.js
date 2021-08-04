export const addFile = (file, end = true) => ({type: 'files/add', file: file, end: end})
export const addFiles = (files, end = true) => ({type: 'files/addMultiple', files: files, end: end})
export const deleteFile = (fileId, softDeleted = false) => ({type: 'file/delete', fileId: fileId, softDeleted: softDeleted}) 
export const toggleSelectFile = (fileId) => ({type: 'files/toggleSelect', fileId: fileId})
export const trashMode = () => ({type: 'filter/toggleTrash'});