import { create, registerPlugin } from 'filepond';
import 'filepond/dist/filepond.css';


// Import the Image Preview plugin
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
// Register the plugin with FilePond
registerPlugin(FilePondPluginImagePreview);
// Import the File Type Validation plugin
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
// Register the plugin with FilePond
registerPlugin(FilePondPluginFileValidateType);

const imagesInput = document.querySelector("input[name='images[]']");
const attachmentInput = document.querySelector("input[name='attachments[]']");

// Create a FilePond instance
create(imagesInput, {
    storeAsFile: true,
    allowMultiple:true,
    // required:true,
    acceptedFileTypes: ['image/*'],
    labelIdle:'قم بتحميل أو إدراج الصور هنا',
    labelFileTypeNotAllowed:'هذا الحقل مخصص للصور فقط',
    name:'images[]'
});


// Create a FilePond instance
create(attachmentInput, {
    storeAsFile: true,
    allowMultiple:true,
    acceptedFileTypes: ['application/*'],
    labelIdle:'قم بتحميل أو إدراج الشيك هنا',
    labelFileTypeNotAllowed:'هذا الحقل مخصص لملفات الوورد والاكسل فقط',
    name:'attachments[]'
});

