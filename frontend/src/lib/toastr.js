import toastrLib from 'toastr';

export const toastr = {
  info: toastrLib.info,
  error: toastrLib.error,
  success: toastrLib.success,
};

export const defaultError = () => toastr.error('An error occurred!');
