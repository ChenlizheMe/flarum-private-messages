function makeSixDigitHexCode(hexColor) {
  if (hexColor.length !== 4)
    return hexColor;

  return '#' + hexColor[1] + hexColor[1] + hexColor[2] + hexColor[2] + hexColor[3] + hexColor[3];
}

export function getNeoncubePrivateMessagesDefaultColors() {
  const computedStyles = getComputedStyle(document.documentElement, null);

  return {
    senderBackgroundColor: makeSixDigitHexCode(computedStyles.getPropertyValue('--primary-color')),
    recipientBackgroundColor: '#9CBF3E',
    senderTextColor: makeSixDigitHexCode(computedStyles.getPropertyValue('--secondary-color')),
    recipientTextColor: '#000000'
  }
}

export function getNeoncubePrivateMessagesColors(app) {
  const defaultColors = getNeoncubePrivateMessagesDefaultColors();

  const enableCustomColors = app.forum.attribute('neoncubePrivateMessagesEnableCustomColors');

  return {
    senderBackgroundColor: (enableCustomColors && app.forum.attribute('neoncubePrivateMessagesSenderBackgroundColor') || null) ?? defaultColors.senderBackgroundColor,
    recipientBackgroundColor: (enableCustomColors && app.forum.attribute('neoncubePrivateMessagesRecipientBackgroundColor') || null) ?? defaultColors.recipientBackgroundColor,

    senderTextColor: (enableCustomColors && app.forum.attribute('neoncubePrivateMessagesSenderTextColor') || null) ?? defaultColors.senderTextColor,
    recipientTextColor: (enableCustomColors && app.forum.attribute('neoncubePrivateMessagesRecipientTextColor') || null) ?? defaultColors.recipientTextColor
  };
}