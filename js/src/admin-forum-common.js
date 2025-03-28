function makeSixDigitHexCode(hexColor) {
  if (hexColor.length !== 4)
    return hexColor;

  return '#' + hexColor[1] + hexColor[1] + hexColor[2] + hexColor[2] + hexColor[3] + hexColor[3];
}

export function getNeoncubePrivateMessagesDefaultColors(initialInstalledVersion) {
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

export function getNeoncubePrivateMessagesColors(app) {
  const initialInstalledVersion = app.forum.attribute('neoncubePrivateMessagesInitialInstalledVersion');

  const defaultColors = getNeoncubePrivateMessagesDefaultColors(initialInstalledVersion);

  const enableCustomColors = app.forum.attribute('neoncubePrivateMessagesEnableCustomColors');

  return {
    senderBackgroundColor: (enableCustomColors && app.forum.attribute('neoncubePrivateMessagesSenderBackgroundColor') || null) ?? defaultColors.senderBackgroundColor,
    recipientBackgroundColor: (enableCustomColors && app.forum.attribute('neoncubePrivateMessagesRecipientBackgroundColor') || null) ?? defaultColors.recipientBackgroundColor,

    senderTextColor: (enableCustomColors && app.forum.attribute('neoncubePrivateMessagesSenderTextColor') || null) ?? defaultColors.senderTextColor,
    recipientTextColor: (enableCustomColors && app.forum.attribute('neoncubePrivateMessagesRecipientTextColor') || null) ?? defaultColors.recipientTextColor
  };
}