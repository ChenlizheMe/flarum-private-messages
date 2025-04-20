function makeSixDigitHexCode(hexColor) {
  if (hexColor.length !== 4)
    return hexColor;

  return '#' + hexColor[1] + hexColor[1] + hexColor[2] + hexColor[2] + hexColor[3] + hexColor[3];
}

export function getChenlizheMePrivateMessagesDefaultColors(initialInstalledVersion) {
  const useOldDefaultColors = initialInstalledVersion === '1.4.0';

  const computedStyles = getComputedStyle(document.documentElement, null);

  return {
    senderBackgroundColor: makeSixDigitHexCode(computedStyles.getPropertyValue('--primary-color')),
    recipientBackgroundColor: useOldDefaultColors ?
      makeSixDigitHexCode(computedStyles.getPropertyValue('--muted-more-color'))
      :
      '#9CBF3E',
    senderTextColor: useOldDefaultColors ?
      makeSixDigitHexCode(computedStyles.getPropertyValue('--secondary-color'))
      :
      makeSixDigitHexCode(computedStyles.getPropertyValue('--text-color')),
    recipientTextColor: useOldDefaultColors ?
      makeSixDigitHexCode(computedStyles.getPropertyValue('--secondary-color'))
      :
      '#000000'
  }
}

export function getChenlizheMePrivateMessagesColors(app) {
  const initialInstalledVersion = app.forum.attribute('chenlizhemePrivateMessagesInitialInstalledVersion');

  const defaultColors = getChenlizheMePrivateMessagesDefaultColors(initialInstalledVersion);

  const enableCustomColors = app.forum.attribute('chenlizhemePrivateMessagesEnableCustomColors');

  return {
    senderBackgroundColor: (enableCustomColors && app.forum.attribute('chenlizhemePrivateMessagesSenderBackgroundColor') || null) ?? defaultColors.senderBackgroundColor,
    recipientBackgroundColor: (enableCustomColors && app.forum.attribute('chenlizhemePrivateMessagesRecipientBackgroundColor') || null) ?? defaultColors.recipientBackgroundColor,

    senderTextColor: (enableCustomColors && app.forum.attribute('chenlizhemePrivateMessagesSenderTextColor') || null) ?? defaultColors.senderTextColor,
    recipientTextColor: (enableCustomColors && app.forum.attribute('chenlizhemePrivateMessagesRecipientTextColor') || null) ?? defaultColors.recipientTextColor
  };
}